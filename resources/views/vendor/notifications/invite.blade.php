@extends('mail')
{{-- Action Button --}}

@section('greeting')
Hi!
@endsection

@section('intro')
Please see below employee documents that will expire in 30 days.
@endsection

@section('content')

@if(!empty($data['qids']->toArray()))
<h2>QIDs</h2>
@foreach($data['qids'] as $qid)
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
	<tr>
		<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            	<tr>
					<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        	<tr>
								<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$qid->emp_id}} - {{$qid->name}} - ({{$qid->qid}} - {{$qid->qid_expiry->format('F d, Y')}})</p>
                                </td>
                            </tr>
                        </table>
					</td>
                </tr>
            </table>
		</td>
    </tr>
</table>
@endforeach
@endif

@if(!empty($data['passports']->toArray()))
<h2>Passports</h2>
@foreach($data['passports'] as $pass)
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <tr>
                    <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$pass->emp_id}} - {{$pass->name}} - ({{$pass->passport}} - {{$pass->passport_expiry->format('F d, Y')}})</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endforeach
@endif

@if(!empty($data['hcs']->toArray()))
<h2>Health Cards</h2>
@foreach($data['hcs'] as $hc)
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <tr>
                    <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$hc->emp_id}} - {{$hc->name}} - ({{$hc->health_card}} - {{$hc->hc_expiry->format('F d, Y')}})</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endforeach
@endif

@if(!empty($data['lics']->toArray()))
<h2>Licenses</h2>
@foreach($data['lics'] as $lic)
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <tr>
                    <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$lic->user()->first()->emp_id}} - {{$lic->user()->first()->name}} - ({{$lic->license}} - {{$lic->expiry_date->format('F d, Y')}})</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endforeach
@endif

@if(!empty($data['visas']->toArray()))
<h2>Visas</h2>
@foreach($data['visas'] as $visa)
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <tr>
                    <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$visa->interior}} - {{$visa->app_num}}  (Expiration Date: {{$visa->visa_expiry_date->format('F d, Y')}})</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endforeach
@endif


@endsection

@section('outro')
For your action.
@endsection

@section('salutation')
Regards
@endsection