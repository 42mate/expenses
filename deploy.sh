SERVER='expense.casivaagustin.com.ar';
USER='root';

rsync  -e 'ssh -p 22' \
-rlz --verbose --checksum --delete --itemize-changes \
--exclude 'storage/app/public' \
--exclude 'vendor' \
--exclude 'node_modules' \
"./src/." "$USER@$SERVER:/var/www/expense.casivaagustin.com.ar/"

ssh $USER@$SERVER "export TERM=xterm;
    set -e;
    cd /var/www/$SERVER;
    composer install;
    composer dumpautoload -o;
    echo "Setup DEV environment";
    cp .env.prd .env;
    echo "Starting migrations";
    php artisan migrate -v --no-interaction;
    php artisan vendor:publish --all -v --no-interaction;
    php artisan cache:clear -v --no-interaction;
    #php artisan storage:link -v --no-interaction;

    chown -R www-data.www-data /var/www/$SERVER;
    chmod -R g+w /var/www/$SERVER;

    /root/.nvm/versions/node/v10.16.3/bin/npm install;
    /root/.nvm/versions/node/v10.16.3/bin/npm run prod;
"