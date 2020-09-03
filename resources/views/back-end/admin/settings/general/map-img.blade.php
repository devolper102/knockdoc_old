   <div class="dc-dashboardbox">
           
                <div class="dc-dashboardboxtitle">

                        	<h2>Add Map Image</h2>
                </div>
                <div class="dc-dashboardboxcontent dc-addspeciality">

                    <form action="{{ url('admin/store-map-img') }}"method="post"enctype="multipart/form-data"> 
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="form-group">
                                <input type="hidden" name="map_img" id="map_img" class="form-control" value="map_img">
                             </div>
                                 <div class="dc-settingscontent form-group">
                                    <div class = "dc-formtheme dc-userform form-group">
                                         <upload-media
                                                :img="'map_image'"
                                                :img_id="'map_image'"
                                                :img_name="'map_image'"
                                                :img_ref="'map_image'"
                                                :img_hidden_name="'map_image'"
                                                img_hidden_id="'map_image'"
                                                :url="'{{ url("media/upload-temp-image/markers/map_image") }}'"
                                        >
                                        </upload-media>

                                    </div>



                                
                                <div class="dc-experienceaccordion">
                                  <div class="dc-updatall la-updateall-holder">
                                      <button type="submit" name="submit" class="dc-btn">Save & Update</button>
                                  </div>
                                  </div>      
                        </div> 

                    </form>
                             </div>
                                @php
                                $map_data =   DB::table('site_managements')->having('meta_key', 'map_img')->latest()->limit(1)->get();
                                @endphp
                                @foreach ($map_data->reverse() as $key => $data)
                                @if($data !='')
                                 <div class="dc-dashboardboxtitle">
                                     <h2>Map Image</h2>
                                 </div>
                               <div style="height: 100px;width: 100px;">
                                <img  src="{{asset('/uploads/markers/temp/'.$data->meta_value)}}"alt="Map image " style="margin-top: 5px;" />
                                </div>
                                @endif

                                  @endforeach
                </div>
            </div>