@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1 class=" mb-5 text-gray-800">Forms</h1>

    <div class="mb-4">
        See <a href="https://laravelcollective.com/docs/6.0/html#opening-a-form">Laravel Collective Forms</a>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-8">
            <h2>Complete form Sample</h2>
            {!! Form::open(['url' => '#']) !!}
            {!! Form::token() !!}
            <div class="form-group">
                {!! Form::label('email', 'E-Mail Address') !!}
                {!! Form::email('email', '', ['class' => 'form-control', 'id' => 'exampleInputEmail1', 'placeholder' => 'Enter email']) !!}
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.
                </small>
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::email('password', '', ['class' => 'form-control', 'id' => 'exampleInputEmail1', 'placeholder' => 'Password']) !!}
            </div>
            <div class="form-check mb-3">
                {!! Form::checkbox('exampleCheck1', 'value', false, ['class' => 'form-check-input']) !!}
                {!! Form::label('email', 'Check me out', ['class' => "form-check-label"]) !!}
            </div>
            {!! Form::submit('Submit!', [ 'class' =>"btn btn-primary"]); !!}
            {!! Form::close() !!}
            <hr/>

            <h2>Elements</h2>

            <div class="form-group">
                {!! Form::label('Select') !!}

                {!! Form::select('size', ['L' => 'Large', 'S' => 'Small'], '', ['class' => 'form-control']);  !!}
            </div>

            <div class="form-group">
                {!! Form::label('Mutiple select') !!}
                {!! Form::select('size', ['L' => 'Large', 'S' => 'Small'], '', ['class' => 'form-control' ,'multiple' => 'multiple']);  !!}
            </div>

            <div class="form-group">
                {!! Form::label('Textarea') !!}
                {!! Form::textarea('sampletextarea', '', ['class' => 'form-control']);  !!}
            </div>
            </form>

            {!! Form::label('Checkboxes') !!}

            <div class="form-check">
                {!! Form::checkbox('exampleCheck2', 'value', false, ['class' => 'form-check-input']) !!}
                {!! Form::label('exampleCheck2', 'Check me out', ['class' => "form-check-label"]) !!}
            </div>
            <div class="form-check">
                {!! Form::checkbox('exampleCheck3', 'value', false, ['class' => 'form-check-input']) !!}
                {!! Form::label('exampleCheck3', 'Check me out', ['class' => "form-check-label"]) !!}
            </div>

            {!! Form::label('Radio') !!}

            <div class="form-check">
                {!! Form::radio('radio1', 'value', false, ['class' => 'form-check-input']) !!}
                {!! Form::label('radio1', 'Check me out', ['class' => "form-check-label"]) !!}
            </div>
            <div class="form-check">
                {!! Form::radio('radio2', 'value', false, ['class' => 'form-check-input']) !!}
                {!! Form::label('radio2', 'Check me out', ['class' => "form-check-label"]) !!}
            </div>

            {!! Form::label('Dates') !!}
            <div class="form-group">
                {!! Form::date('name', \Carbon\Carbon::now());  !!}
            </div>

            {!! Form::label('Files') !!}
            <div class="form-group">
                {!! Form::file('image') !!}
                <div>
                    <small>
                        Note: The form must have been opened with the files option set to true.
                    </small>
                    <pre class="mt-5 mb-5 text-left">Form::open(['url' => 'foo/bar', 'files' => true])</pre>
                </div>
            </div>

            <hr/>

            <h2>Two cols forms</h2>

            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="form-group">
                    <label for="inputAddress2">Address 2</label>
                    <input type="text" class="form-control" id="inputAddress2"
                           placeholder="Apartment, studio, or floor">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>

            <hr/>

            <h2>Validations</h2>

            <form>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationServer01">First name</label>
                        <input type="text" class="form-control is-valid" id="validationServer01"
                               placeholder="First name" value="Mark" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Last name</label>
                        <input type="text" class="form-control is-valid" id="validationServer02" placeholder="Last name"
                               value="Otto" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServerUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3">@</span>
                            </div>
                            <input type="text" class="form-control is-invalid" id="validationServerUsername"
                                   placeholder="Username" aria-describedby="inputGroupPrepend3" required>
                            <div class="invalid-feedback">
                                Please choose a username.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer03">City</label>
                        <input type="text" class="form-control is-invalid" id="validationServer03" placeholder="City"
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer04">State</label>
                        <input type="text" class="form-control is-invalid" id="validationServer04" placeholder="State"
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer05">Zip</label>
                        <input type="text" class="form-control is-invalid" id="validationServer05" placeholder="Zip"
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
                        <label class="form-check-label" for="invalidCheck3">
                            Agree to terms and conditions
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit form</button>
            </form>

        </div>
    </div>
@endsection
