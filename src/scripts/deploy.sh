#
# Deployment Script
#
# You need to source .server_env first in your local
# The user needs to have setted up the ssh keys to access to the server configured en server_env
# The servers needs to have their .env configured in prod
#
# Run this script with an user that has the ssh key configured to access to the server
#
set -eu

source .server_env

for SERVER in ${SERVERS[@]};
do
ssh "${SSH_USER}@${SERVER}" "
  cd ${WORKSPACE} || exit 1;
  echo 'Shutdown App n ${SERVER}';
  sudo -u www-data -- $PHP artisan down;
"
done
wait

for SERVER in ${SERVERS[@]};
do
   /usr/bin/rsync --rsync-path 'sudo -u www-data rsync' -e "ssh -o StrictHostKeyChecking=no" -rlz --checksum --delete --itemize-changes --exclude '.git' --exclude='.env' --exclude "storage" --no-owner --no-group --chown=www-data:www-data "." "$SSH_USER@$SERVER:$WORKSPACE" &
done
wait

for SERVER in ${SERVERS[@]};
do
ssh ${SSH_USER}@${SERVER} "
  set -eu
  export TERM=xterm;

  printf \"Changing to web directory '%s'\n\" ${WORKSPACE};
  cd ${WORKSPACE} || exit 1;

  echo 'Creating directories related to Laravel'

  sudo -u www-data -- mkdir -p \
    $WORKSPACE/storage/logs \
    $WORKSPACE/storage/framework/sessions \
    $WORKSPACE/storage/framework/logs \
    $WORKSPACE/storage/framework/cache \
    $WORKSPACE/storage/framework/views

  sudo -u www-data -- $PHP /usr/bin/composer dumpautoload -o -a;

  echo 'Linking storage directory';
  sudo -u www-data -- $PHP artisan storage:link -v --no-ansi --no-interaction;
  sudo -u www-data -- $PHP artisan vendor:publish --all -v --no-interaction;
"
done
wait

echo "Running Artisan"

ssh ${SSH_USER}@${ARTISAN} "
  set -eu
  export TERM=xterm;

  printf \"Changing to web directory '%s'\n\" ${WORKSPACE};
  cd ${WORKSPACE} || exit 1;

  echo 'Flushing cache';
  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction cache:clear;
  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction route:clear;
  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction config:clear;
  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction clear-compiled;
  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction optimize:clear;

  echo 'Running database migrations';
  sudo -u www-data -- $PHP artisan migrate;

  echo 'Reloading supervisor configuration';

#  Reload the daemon’s configuration files, without add/remove (no restarts)
#  sudo supervisorctl reread;

#  Reload config and add/remove as necessary, and will restart affected programs
#  sudo supervisorctl update;

#  Start Horizon master process
#  sudo supervisorctl start 'laravel-horizon:*';

#  echo 'Terminating Horizon master process';
#  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction horizon:terminate;

#  echo 'Interrupting scheduler sub-minute tasks';
#  sudo -u www-data -- $PHP artisan --no-ansi --no-interaction schedule:interrupt;

#  echo 'Running tests'
#  sudo -u www-data -- $PHP artisan test --exclude-group clients;

   sudo -u www-data -- $PHP artisan --no-ansi --no-interaction optimize;
   sudo -u www-data -- $PHP /usr/bin/composer dumpautoload -o -a;
"

for SERVER in ${SERVERS[@]};
do
ssh ${SSH_USER}@${SERVER} "
  cd ${WORKSPACE} || exit 1;
  echo 'Starting App n ${SERVER}';
  sudo -u www-data -- $PHP artisan up;
"
done
wait
