@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row center-div">
            <h1>Alert Profile</h1>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading center-div"><h4>Mobile Phones</h4></div>
                    <div class="table-responsive">
                        <br/>
                        <table id="phoneTable" class=" table table-striped table-hover table-condensed
                        ">
                            <thead>
                            <form name="new-phone-form" id="new-phone-form" role="form" data-toggle="validator">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="center-div">
                                            <input data-error="Provide a 10 digit number" data-minlength="10"
                                                   maxlength="10" pattern="^\d{10}$" required="required"
                                                   placeholder="Mobile Number" name="number" id="number"
                                                   class="form-control"
                                                   type="text">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="center-div">
                                            <select data-error="Select a carrier" required="required"
                                                    id="carrier" name="carrier" class="form-control">
                                            </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="center-div">
                                    <button id="new-phone"
                                            data-new-item="true"
                                            data-item-type="phone"
                                            type="submit"
                                            data-ajax--url="/api/v1/user/phone"
                                            class="btn btn-success btn-md">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add
                                    </button>
                                </div>
                            </form>
                            </thead>
                            <tbody>
                            @if(count($phones) <= 0)
                                <tr id="phone-placeholder">
                                    <td>
                                        <div class="center-div">
                                            <h4>You have not added any phones yet.</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="center-div"></div>
                                    </td>
                                </tr>
                            @else

                                @foreach($phones as $phone)
                                    <tr id="phone-{{$phone->id}}" @if(!$phone->verified)class="warning"@endif>
                                        <td>
                                            @if($phone->verified)
                                                <div class="col-md-9">
                                                    <h4>{{$phone->number_formatted}}</h4>
                                                </div>
                                            @else
                                                <div class="col-md-9">
                                                    <h4>{{$phone->number_formatted}} - Unverified</h4>
                                                </div>
                                            @endif

                                            <div class="center-div">
                                                @if(!$phone->verified)
                                                    <a href="/verify" class="btn btn-sm btn-success"><i
                                                                class="fa fa-check-circle" aria-hidden="true"></i>
                                                        Verify</a>
                                                @endif
                                                <button id="del-phone-{{$phone->id}}"
                                                        data-item-id="{{$phone->id}}"
                                                        data-item-type="phone"
                                                        data-ajax--url="/api/v1/user/phone/{{$phone->id}}"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading center-div"><h4>Email Addresses</h4></div>
                    <div class="table-responsive">
                        <div class="center-div">
                            <p>The address, <b>{{$auth_email}}</b> will always receive alerts.</p>
                            <p>Would you like to add another address?</p>
                        </div>
                        <table id="emailTable" class="table table-striped table-hover table-condensed">
                            <thead>
                            <form name="new-email-form" id="new-email-form" role="form" data-toggle="validator">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="center-div">
                                            <input data-error="You must provide an email address"
                                                   required="required"
                                                   placeholder="Email Address" name="email" id="email"
                                                   class="form-control"
                                                   type="email">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="center-div">
                                    <button id="new-email"
                                            data-new-item="true"
                                            data-item-type="email"
                                            type="submit"
                                            data-ajax--url="/api/v1/user/email"
                                            class="btn btn-success btn-md">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add
                                    </button>
                                </div>
                            </form>
                            </thead>
                            <tbody>
                            @if(count($emails) <= 0)
                                <tr id="email-placeholder">
                                    <td>
                                        <div class="center-div">
                                            <h4>You have not added any additional emails yet.</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="center-div"></div>
                                    </td>
                                </tr>
                            @else
                                @foreach($emails as $email)
                                    <tr id="email-{{$email->id}}" @if(!$email->verified) class="warning" @endif>
                                        <td>
                                            @if($email->verified)
                                                <div class="col-md-9">
                                                    <h4>{{$email->address}}</h4>
                                                </div>
                                            @else
                                                <div class="col-md-9">
                                                    <h4>{{$email->address}} - Unverified</h4>
                                                </div>
                                            @endif
                                            <div class="center-div">
                                                @if(!$email->verified)
                                                    <a href="/verify" class="btn btn-sm btn-success"><i
                                                                class="fa fa-check-circle" aria-hidden="true"></i>Verify</a>
                                                @endif
                                                <button id="del-email-{{$email->id}}"
                                                        data-item-id="{{$email->id}}"
                                                        data-item-type="email"
                                                        data-ajax--url="/api/v1/user/email/{{$email->id}}"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <script type="text/javascript">
      $('#new-phone-form').validator();
      $('#new-email-form').validator();
    </script>
    <script type="text/javascript">
      var $token_header = 'Bearer ' + localStorage.getItem('accessToken');

      // On a button click delete the object
      $('button').click(function (e) {

        var $type = $(this).data("item-type");
        var $url = $(this).data("ajax--url");
        var $button = this;
        var $had_error = false;

        // If we have this attr continue
        if ($(this).data("item-id")) {
          $(this).prop('disabled', true).html('<i class="fa fa-circle-o-notch" aria-hidden="true"></i> Deleting...');
          var $id = $(this).data("item-id");

          console.log($type + ' - ' + $id + ' - ' + $url);
          $.ajax({
            headers: {
              'Authorization': $token_header
            },
            delay: 250,
            cache: false,
            dataType: 'json',
            url: $url,
            method: 'DELETE',
            error: function (error) {
              console.log(error);
              $('#flash').html('<p class="alert alert-danger center-div"> ' + error.responseJSON.message + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>');
              $($button).prop('disabled', false).html('<i class="fa fa-trash" aria-hidden="true"></i> Delete');
              $had_error = true;
            },
            success: function (result) {
              $('#' + $type + '-' + $id).hide();
              console.log(result);
              /**
               * TODO remove the deleted item to page and return false to not submit the form
               */
              $('#flash').html('<p class="alert alert-success center-div"> ' + $type + ' deleted' + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>');
            }
          });
        }

        if ($(this).data("new-item")) {
          $($button).prop('disabled', true).html('<i class="fa fa-circle-o-notch" aria-hidden="true"></i> Saving...');
          $data = [];
          $form = null;

          if ($type == "phone") {
            $form = $('#new-phone-form');

          } else if ($type == "email") {
            $form = $('#new-email-form');
          }

          $data = $($form).serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
          }, {});

          console.log($data);
          $.ajax({
            headers: {
              'Authorization': $token_header
            },
            delay: 250,
            cache: false,
            dataType: 'json',
            url: $url,
            data: $data,
            method: 'POST',
            error: function (error) {
              console.log(error);
              if (error.responseJSON.message) {
                $('#flash').html('<p class="alert alert-danger center-div"> ' + error.responseJSON.message + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>');
              }
              if (error.responseJSON.error) {
                $e = error.responseJSON.error;
                if ($.isArray($e)) {
                  html = '';
                  $.each($e, function (index, error) {
                    html = html + '<p class="alert alert-danger center-div"> ' + error + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>';
                  });
                  $('#flash').html(html);
                } else {
                  $('#flash').html('<p class="alert alert-danger center-div"> ' + $e + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>');
                }
              }
              $had_error = true;
            },
            success: function (result) {
              $result = result.data;
              console.log($result)

              /**
               * TODO add saved item to page and return false to not submit the form
               */
              $('#flash').html('<p class="alert alert-success center-div"> ' + $type + ' created' + ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </p>');
              if ($type == 'phone') {
                $('#phone-placeholder').remove()
                if ($result.verified) {
                  $('#phoneTable > tbody:last-child').append(
                    '<tr id=phone-"' + $result.id + '" >' +
                    '<td>' +
                    '<div class="col-md-9">' +
                    '<h4>' + $result.formatted + '</h4>' +
                    '</div>' +
                    '<div class="center-div">' +
                    '<button id="del-phone-' + $result.id + '" data-item-id="' + $result.id + '" data-item-type="phone" data-ajax--url="/api/v1/user/phone/' + $result.id + '" class="btn btn-danger btn-sm">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i> Delete' +
                    '</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                  );
                } else {
                  $('#phoneTable > tbody:last-child').append(
                    '<tr id=phone-"' + $result.id + '" class="warning" >' +
                    '<td>' +
                    '<div class="col-md-9">' +
                    '<h4>' + $result.formatted + ' - Unverified</h4>' +
                    '</div>' +
                    '<div class="center-div">' +
                    '<a href="/verify" class="btn btn-sm btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i>Verify</a>' +
                    '<button id="del-phone-' + $result.id + '" data-item-id="' + $result.id + '" data-item-type="phone" data-ajax--url="/api/v1/user/phone/' + $result.id + '" class="btn btn-danger btn-sm">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i> Delete' +
                    '</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                  );
                }

              } else if ($type == 'email') {
                $('#email-placeholder').remove()
                if ($result.verified) {
                  $('#emailTable > tbody:last-child').append(
                    '<tr id=email-"' + $result.id + '" >' +
                    '<td>' +
                    '<div class="col-md-9">' +
                    '<h4>' + $result.address + '</h4>' +
                    '</div>' +
                    '<div class="center-div">' +
                    '<button id="del-email-' + $result.id + '" data-item-id="' + $result.id + '" data-item-type="email" data-ajax--url="/api/v1/user/email/' + $result.id + '" class="btn btn-danger btn-sm">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i> Delete' +
                    '</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                  );
                } else {
                  $('#emailTable > tbody:last-child').append(
                    '<tr id=email-"' + $result.id + '" class="warning" >' +
                    '<td>' +
                    '<div class="col-md-9">' +
                    '<h4>' + $result.address + ' - Unverified</h4>' +
                    '</div>' +
                    '<div class="center-div">' +
                    '<a href="/verify" class="btn btn-sm btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i>Verify</a>' +
                    '<button id="del-email-' + $result.id + '" data-item-id="' + $result.id + '" data-item-type="email" data-ajax--url="/api/v1/user/email/' + $result.id + '" class="btn btn-danger btn-sm">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i> Delete' +
                    '</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                  );
                }
              }
            }
          });
          $($button).prop('disabled', false).html('<i class="fa fa-plus" aria-hidden="true"></i> Add');
        }
        // if ($had_error) {
        return false;
        // }
      });

      $("#carrier").select2({
        ajax: {
          headers: {
            'Authorization': $token_header
          },
          url: '/api/v1/resources/carriers',
          delay: 250,
          cache: true,
          processResults: function (data, params) {
            var results = [];
            console.log(data)
            $.each(data.data, function (index, value) {
              if (params.term == null) {
                results.push({
                  id: value.id,
                  text: value.label,
                  'value': value.id
                });
              } else {
                if (value.label.toLowerCase().indexOf(params.term.toLowerCase()) != -1) {
                  results.push({
                    id: value.id,
                    text: value.label,
                    'value': value.id
                  });
                }
              }
            });
            return {
              results: results
            };
          }
        },
        placeholder: {
          id: '-1',
          text: 'Mobile Carrier'
        },
        theme: 'bootstrap',
        allowClear: true,
        minimumResultsForSearch: 2,
        maximumInputLength: 20
      });
    </script>
@endsection
