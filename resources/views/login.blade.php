@extends('New-Template')
@section('content')
<div class="row justify-content-center mx-auto">
    <div class="col-12 col-lg-6">
        <div class="card my-5">
            <div class="card-body">
              <p class="card-title fw-bold text-center fs-2">LOGIN</p>
              <form>
                <div class="mb-3">
                  <label for="email" class="form-label">Email <sup class="text-danger">*</sup></label>
                  <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="xxxxx@xxxx.xxxx" autofocus>
                  <div id="email" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password <sup class="text-danger">*</sup></label>
                  <input type="password" class="form-control" id="password" placeholder="**********">
                </div>
                <button type="submit" class="btn btn-primary float-end">Submit</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
