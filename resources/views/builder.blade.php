@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row center-div">
            <h1>Alert Builder</h1>
        </div>
        <div class="row">
            <form id="alert-form" role="form" data-toggle="validator" method="post" action="{{url('/dispatch')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="subject">Alert Subject</label>
                        <input data-error="You must select an alert subject" required="required" type="text"
                               class="form-control" id="subject" name="subject" placeholder="Snow Removal">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="message">Alert Message</label>
                        <textarea data-error="You must provide an alert message" required="required"
                                  class="form-control" id="message" name="message" rows="3"
                                  placeholder="Snow removal will ..."></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <select data-error="Select an alert method" required="required"
                                    id="method" name="method" class="form-control">
                                <option></option>
                                @permission(['send-email','send-sms'], true)
                                <option value="both">Both</option>
                                @endpermission
                                @ability('admin,power-user,notifier', 'send-email')
                                <option value="email">Email</option>
                                @endability
                                @ability('admin,power-user,notifier', 'send-sms')
                                <option value="mobile">Mobile Phone</option>
                                @endability
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i> Submit
                                Alert
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <script type="text/javascript">
      $('#alert-form').validator();
      $('#method').select2({
        placeholder: 'Alert Method',
        theme: 'bootstrap',
        allowClear: true
      });
    </script>
@endsection