@extends('back-end.master')
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        table>tbody>tr>td{
            text-align: left;
        }
    </style>
@endpush
@section('content')
    @include('includes.pre-loader')
    <div class="dc-specialities" id="specialities">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='100' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='100' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="dc-haslayout">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel">
                            <h2>All Online Consultation Doctors</h2>

                        </div>
                        @if (count($specialities) > 0)
                            <div class="dc-dashboardboxcontent dc-categoriescontentholder">
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Speciality</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>View More</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($specialities as $servkey => $speciality)
                                        <tr>

                                            <td><b>{{{ html_entity_decode(clean($service = Helper::getServiceByID($servkey)->title)) }}}</b></td>

                                            @if(count($speciality) > '6')
                                                @foreach ($speciality as $key => $user)

                                                    @if( $key < '5')
                                                        <td class="{{$key}}">

                                                            <a style="color: #3fabf3" target="_blank" href="{{ url('/profile/'.$user->slug)}}">{{{ html_entity_decode(clean($user->first_name ?? '')) }}}</a>


                                                        </td>

                                                    @elseif ($key == '5' && $key < count($speciality))
                                                        <td> <a style="color: #3fabf3" target="_blank" href="{{ url('admin/moredoc/'.$servkey)}}">view more ({{ count($speciality) - 5}})</a></td>

                                                    @endif
                                                @endforeach
                                            @elseif(count($speciality) < '6' && count($speciality) > '0')

                                                @foreach ($speciality as $key => $user)


                                                    <td class="{{$key}}">

                                                        <a style="color: #3fabf3" target="_blank" href="{{ url('/profile/'.$user->slug)}}">{{{ html_entity_decode(clean($user->first_name ?? '')) }}}</a>

                                                    </td>

                                                @endforeach

                                                @if(count($speciality) < '6' && count($speciality) > '0')
                                                    <?php for ($i=0; $i < 6 - count($speciality) ; $i++) {
                                                        echo "<td></td>";
                                                    } ?>

                                                @endif
                                            @else
                                                <?php for ($i=0; $i < 6; $i++) {
                                                    echo "<td></td>";
                                                } ?>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                            </div>
                        @else
                            @include('errors.no-record')
                        @endif
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
