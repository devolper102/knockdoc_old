@extends('back-end.master')
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        table>tbody>tr>td{
            text-align: left;
        }
        #example .dtr-details .dtr-data {
            white-space: pre-wrap !important;
        }
        #example .dtr-details .dtr-data .btn-danger {
            margin-top: -10px;
        }
        .btn-primary.disabled, .btn-primary:disabled{
            background-color: #b9b9b9;
            border-color: #b9b9b9;
        }
    </style>
@endpush
@section('content')
    @include('includes.pre-loader')
    <div class="dc-specialities" id="specialities">
        <section class="dc-haslayout">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel">
                            <h2>Manage Hospitals Reviews Approval/Decline</h2>
                        </div>
                        <div class="dc-dashboardboxcontent dc-categoriescontentholder table-responsive">
                            <table id="example"  style="width:100%"class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Doctor Name</th>
                                    <th>Waiting Time</th>
                                    <th>Average Rating</th>
                                    <th>Keep Anonymous</th>
                                    <th>Comments</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                @foreach($users as $user)
                                    @foreach($user->feedbacks as $feedbacks)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td><p style="text-align: left;">
                                                {{Helper::getUserData($user->id)}}
                                            </p></td>
                                            <td>{{$feedbacks->waiting_time}}</td>
                                            <td>{{$feedbacks->avg_rating}}</td>
                                            <td>{{$feedbacks->keep_anonymous}}</td>
                                            <td>{{$feedbacks->comment}}</td>
                                            <td>
                                                <div class="dc-actionbtn">
                                                    @if($feedbacks->approval === 0)
                                                        <a class="dc-addinfo dc-skillsaddinfo" onclick="location.href='{{ url('admin/feedback',[$status = 1,$feedbacks->id]) }}'"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    @else
                                                        <a class="dc-addinfo dc-skillsaddinfo" onclick="location.href='{{ url('admin/feedback',[$status = 0,$feedbacks->id]) }}'"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    @endif
                                                    <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ $feedbacks->id }}'" :message="'{{'Feedback Deleted Successfully'}}'" :url="'{{url('admin/feedback/delete')}}'" :redirect_url="'{{url('admin/feedback')}}'"class="btn btn-danger btn-sm"></delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    @stack('backend_scripts')

    <script type="text/javascript">


      jQuery(document).ready(function() {
        jQuery('#example').DataTable();
      } );

    </script>

@endpush
