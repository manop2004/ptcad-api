@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
	a{
		font-weight: 700;
	}
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
	.badge-secondary {
		color: #fff;
		background-color: #6c757d;
	}
	.badge-dark {
		color: #fff;
		background-color: #343a40;
	}
	.badge.badge-success {
		width: auto;
	}
	.badge.badge-secondary, .badge.badge-warning, .badge.badge-success, .badge.badge-dark {
        font-size: 14px;
		padding: 10px;
		margin-bottom: 20px;
    }
	h6, .h6{
		text-transform: none;
		font-weight: 500;
	}
	.badge.badge-primary {
		color: #fff;
		background-color: #007bff;
    }
	.row{
		margin-bottom: 5px;
	}
	

	@media (min-width:992px) {
		.page-container {
			max-width: 1140px;
			margin: 0 auto
		}

		.page-sidenav {
			display: block !important
		}
	}

	.padding {
		padding: 2rem
	}

	.w-32 {
		width: 32px !important;
		height: 32px !important;
		font-size: .85em
	}

	.tl-item .avatar {
		z-index: 2
	}

	.circle {
		border-radius: 500px
	}

	.gd-warning {
		color: #fff;
		border: none;
		background: #f4c414 linear-gradient(45deg, #f4c414, #f45414)
	}

	.timeline {
		position: relative;
		border-color: rgba(160, 175, 185, .15);
		padding: 0;
		margin: 0
	}

	.p-4 {
		padding: 1.5rem !important
	}

	.block,
	.card {
		background: #fff;
		border-width: 0;
		border-radius: .25rem;
		box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
		margin-bottom: 1.5rem
	}

	.mb-4,
	.my-4 {
		margin-bottom: 1.5rem !important
	}

	.tl-item {
		border-radius: 3px;
		position: relative;
		display: -ms-flexbox;
		display: flex
	}

	.tl-item>* {
		padding: 10px
	}

	.tl-item .avatar {
		z-index: 2
	}

	.tl-item:last-child .tl-dot:after {
		display: none
	}

	.tl-item.active .tl-dot.b-secondary:before {
		border-color: #6c757d;
		box-shadow: 0 0 0 4px rgba(147,154,160,.2);
	}
	
	.tl-item.active .tl-dot.b-warning:before {
		border-color: #fbc658;
		box-shadow: 0 0 0 4px rgba(252,218,147,.2);
	}
	
	.tl-item.active .tl-dot.b-success:before {
		border-color: #6bd098;
		box-shadow: 0 0 0 4px rgba(152,236,189,.2);
	}

	.tl-item:last-child .tl-dot:after {
		display: none
	}
	
	.tl-dot {
		position: relative;
		border-color: rgba(160, 175, 185, .15)
	}

	.tl-dot:after,
	.tl-dot:before {
		content: '';
		position: absolute;
		border-color: inherit;
		border-width: 2px;
		border-style: solid;
		border-radius: 50%;
		width: 10px;
		height: 10px;
		top: 15px;
		left: 50%;
		transform: translateX(-50%)
	}

	.tl-dot:after {
		width: 0;
		height: auto;
		top: 25px;
		bottom: -15px;
		border-right-width: 0;
		border-top-width: 0;
		border-bottom-width: 0;
		border-radius: 0
	}

	.tl-item.active .tl-dot.b-secondary:before {
		border-color: #6c757d;
		box-shadow: 0 0 0 4px rgba(147,154,160,.2);
	}
	
	.tl-item.active .tl-dot.b-warning:before {
		border-color: #fbc658;
		box-shadow: 0 0 0 4px rgba(252,218,147,.2);
	}
	
	.tl-item.active .tl-dot.b-success:before {
		border-color: #6bd098;
		box-shadow: 0 0 0 4px rgba(152,236,189,.2);
	}

	.tl-dot {
		position: relative;
		border-color: rgba(160, 175, 185, .15)
	}

	.tl-dot:after,
	.tl-dot:before {
		content: '';
		position: absolute;
		border-color: inherit;
		border-width: 2px;
		border-style: solid;
		border-radius: 50%;
		width: 10px;
		height: 10px;
		top: 15px;
		left: 50%;
		transform: translateX(-50%)
	}

	.tl-dot:after {
		width: 0;
		height: auto;
		top: 25px;
		bottom: -15px;
		border-right-width: 0;
		border-top-width: 0;
		border-bottom-width: 0;
		border-radius: 0
	}

	.tl-content p:last-child {
		margin-bottom: 0
	}

	.tl-date {
		font-size: .85em;
		margin-top: 2px;
		min-width: 100px;
		/*max-width: 100px*/
	}

	.avatar {
		position: relative;
		line-height: 1;
		border-radius: 500px;
		white-space: nowrap;
		font-weight: 700;
		border-radius: 100%;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-pack: center;
		justify-content: center;
		-ms-flex-align: center;
		align-items: center;
		-ms-flex-negative: 0;
		flex-shrink: 0;
		border-radius: 500px;
		box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
	}

	.b-warning {
		border-color: #f4c414!important;
	}

	.b-primary {
		border-color: #448bff!important;
	}

	.b-danger {
		border-color: #f54394!important;
	}

	.b-secondary {
		border-color: #6c757d!important;
	}

	.b-success {
		border-color: #28a745!important;
	}

 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'ticket.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['ticket.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
							<div class="row">
								<div class="col-md-12">
										<h5 class="title">
											Ticket ID : <a href="#" style="text-decoration: none">@if(!empty($data->code)){{ $data->code }}@else{{ $ticket }}@endif</a>
											<span class="pull-right {{ $data->statusclass }}">{{ $data->statusname }}</span>
										</h5>
									
									<input type="hidden" id="code" name="code" value="@if(!empty($data->code)){{ $data->code }}@else{{ $ticket }}@endif" />
								</div>
							</div>
							<br>
							<div class="row">
                                <div class="col-md-12">
									<h6>
										ชื่อผู้ติดต่อ  : &nbsp; <strong>@if(!empty($data->name)){{ $data->name }}@endif @if(!empty($data->lastname)){{ $data->lastname }}@endif</strong>
									</h6>
									<input type="hidden" id="name" name="name" @if(!empty($data->name)){{ $data->name }}@else{{ old('name') }}@endif  />
									<input type="hidden" id="lastname" name="lastname" @if(!empty($data->lastname)){{ $data->lastname }}@else{{ old('lastname') }}@endif  />
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
									<h6>
										ชื่อบริษัท  : &nbsp; <a href="#" style="text-decoration: none">@if(!empty($data->company)){{ $data->company }}@endif</a>
									</h6>
									
                                </div>
                            </div>
							
							<!--div class="row">
                                <div class="col-md-12">
									<h6>
										ช่วงเวลาที่สะดวกให้ติดต่อกลับ  : &nbsp; <span style="color: red;"><strong>@if(!empty($data->available_time)){{ $data->available_time }}@endif</strong></span>
									</h6>
									<input type="hidden" id="available_time" name="available_time" @if(!empty($data->available_time)){{ $data->available_time }}@else{{ old('available_time') }}@endif  />
                                </div>
                            </div-->
							
							<div class="row">
                                <div class="col-md-6">
									<h6>
										เบอร์โทรศัพท์  : &nbsp; <strong>@if(!empty($data->tel)){{ $data->tel }}@endif</strong>
									</h6>
									<input type="hidden" id="tel" name="tel" @if(!empty($data->tel)){{ $data->tel }}@else{{ old('tel') }}@endif  />
                                </div>
								<div class="col-md-6">
									<h6>
										อีเมล  : &nbsp; <strong>@if(!empty($data->email)){{ $data->email }}@endif</strong>
									</h6>
									<input type="hidden" id="email" name="email" @if(!empty($data->email)){{ $data->email }}@else{{ old('email') }}@endif  />
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-md-12">
									<h6>
										ช่องทางที่ติดต่อเข้ามา  : &nbsp; <span><strong>@if(!empty($data->request_channel)){{ $data->request_channel }}@endif</strong></span>
									</h6>
                                </div>
                            </div>
							
							<hr>
							<div class="row">
                                <div class="col-md-12">
									<h6>
										โปรแกรมที่ขอใช้บริการ  : 
										<?php 
											if(!empty($data->program)){
												if(strpos($data->program, ',') !== FALSE){
													$arr_subject = explode(',',$data->program);
													foreach($arr_subject as $program){
														echo '<span class="badge badge-primary">'.$program.'</span> ';
													}
												}else{
														echo '<span class="badge badge-primary">'.$data->program.'</span>';
												}
											}
										?>
									</h6>
                                </div>
                            </div>
							<!--div class="row">
                                <div class="col-md-12">
									<h6>
										เรื่องที่ติดต่อ  : &nbsp; <strong>@if(!empty($data->subject)){{ $data->subject }}@endif</strong>
									</h6>
									<input type="hidden" id="subject" name="subject" @if(!empty($data->subject)){{ $data->subject }}@else{{ old('subject') }}@endif  />
                                </div>
                            </div-->
							
							<div class="row">
                                <div class="col-md-12">
									<h6>
										รายละเอียด  : &nbsp; 
										<div class="d-inline-flex flex-column"><strong>@if(!empty($data->message)){!! $data->message !!}@endif</strong></div>
									</h6>
									<input type="hidden" id="message" name="message" @if(!empty($data->message)){{ $data->message }}@else{{ old('message') }}@endif  />
                                </div>
                            </div>
							
							@if(count($ticketFile) != 0)
							<div class="row">
                                <div class="col-md-12">
									<h6>
										ไฟล์แนบ  : &nbsp; 
										<div class="d-inline-flex flex-row">
											@foreach ($ticketFile as $file)
												<a target="_bank" href="{{ asset('storage/ticket/'.$file->name) }}" class="px-1"><img src="{{ asset('storage/ticket/'.$file->name) }}" height="100" class="border"></a>
											@endforeach
										</div>
									</h6>
								</div>
							</div>
							@endif
							
							<br>
							<div class="row">
                                <div class="col-md-6">
									<h6>
										ชื่อเจ้าหน้าที่ฝ่ายขายที่ดูแล  : &nbsp; <a href="#" style="text-decoration: none; text-transform: uppercase;">@if(!empty($data->sales_name)){{ $data->sales_name }}@endif</a>
									</h6>
									<input type="hidden" id="sales_name" name="sales_name" @if(!empty($data->sales_name)){{ $data->sales_name }}@else{{ old('sales_name') }}@endif  />
                                </div>
								<div class="col-md-6">
									<h6>
										Email CC  : &nbsp; @if(!empty($data->email_cc)){{ $data->email_cc }}@endif
									</h6>
									<input type="hidden" id="email_cc" name="email_cc" @if(!empty($data->email_cc)){{ $data->email_cc }}@else{{ old('email_cc') }}@endif  />
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-md-6">
									<h6>
										ผู้แจ้ง  : &nbsp; <a href="#" style="text-decoration: none; text-transform: uppercase;">@if(!empty($data->created_by)){{ $data->created_by }}@endif</a> 
										<span >( @if(!empty($data->created_at)){{ date('d/m/Y H:i',strtotime($data->created_at))}}@endif )</span>
									</h6>
                                </div>
								<div class="col-md-6">
									<h6>
										ผู้รับเรื่อง  : &nbsp; <a href="#" style="text-decoration: none; text-transform: uppercase;">@if(!empty($data->staffname)){{ $data->staffname }}@endif</a> 
										<span >@if(!empty($data->assigned_at) && !empty($data->staffId))( {{ date('d/m/Y H:i',strtotime($data->assigned_at)) }} )@endif</span>
									</h6>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					
					<div class="page-content page-container" id="page-content">
						<div class="row">
					
							<div class="col-lg-12">
								<p>Timeline</p>
								<div class="timeline p-4 block mb-4">
								
									<?php
										$line = 1;
										foreach($HistoryTicket as $history){
											$active = $line==1 ? 'active' : '';
											
											$color_timeline = "";
											if($history->status == '1'){
												$color_timeline = "b-secondary";
											}else if($history->status == '2'){
												$color_timeline = "b-warning";
											}else{
												$color_timeline = "b-success";
											}
											
									?>
									<div class="tl-item <?php echo $active; ?>">
										<div class="tl-dot <?php echo $color_timeline; ?>"></div>
										<div class="tl-content">
											<div>
												<i style="font-weight: 700;"><?php echo $history->note != '' ? nl2br($history->note) : ''; ?></i>
											</div>
											<div style="font-size: 12px;">
												<?php
													if(!empty($history->score)){
														echo "<strong style='color: #6bd098; font-size: 14px;'>".$history->remark."</strong>";
														if($allow_score){
															echo " <strong style='color: red; font-size: 14px;'>( ".$history->score." )</strong>";
														}
													}else{
														echo str_replace(',','<br>',$history->remark); 
													}
												?>
											</div>
											<div class="tl-date text-muted mt-1"><?php echo $history->updated_by.' - '.date('d/m/Y H:i',strtotime($history->created_at)) ?></div>
										</div>
									</div>
									<?php
												
											$line++;
										}
									?>
								
									
								</div>
							</div>
					

						</div>
					</div>
                </div>
                <div class="col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group has-label">
                                <label>พนักงานที่รับผิดชอบ</label>
                                <select id="staffId" name="staffId" class="form-control">
                                    <option value="">--เลือกข้อมูล--</option>
                                    @foreach ($users as $user )
                                        <option value="{{ $user->id }}" @if(!empty($data->staffId)) @if($user->id == $data->staffId) selected @endif @endif>{{ $user->name }} {{ $user->lastname }}</option>
                                    @endforeach
                                </select>
                                @error('staffId')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>สถานะการบริการ</label>
                                <select id="status" name="status" class="form-control">
                                    <!--option  @if(!empty($data)) @if(1 == $data->status) selected @endif @endif value="1">Open</option-->
                                    <option  @if(!empty($data)) @if(2== $data->status) selected @endif @endif value="2">In Progress</option>
                                    <option  @if(!empty($data)) @if(3 == $data->status) selected @endif @endif value="3">Resolved</option>
                                    <option  @if(!empty($data)) @if(4 == $data->status) selected @endif @endif value="4">Cancel</option>
                                </select>
                                @error('status')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
							
							<div class="form-group has-label">
                                <label>ชื่อบริษัท</label>
                                <input type="text" id="company" name="company" value="@if(!empty($data->company)){{ $data->company }}@else{{ old('company') }}@endif" class="form-control">
                                @error('company')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
							
							<div class="form-group has-label">
								<label>โปรแกรมที่ขอใช้บริการ</label>
								<select id="program" name="program[]" class="form-control select2" multiple>
									@php
										$selectedPrograms = !empty($data->program) ? explode(',', $data->program) : (old('program') ?? []);
									@endphp
									@foreach ($programs as $program)
										@if($program->name != 'Other(อื่นๆ)')
											<option value="{{ $program->name }}" @if(in_array($program->name, $selectedPrograms)) selected @endif>
												{{ $program->name }}
											</option>
										@endif
									@endforeach
									<option value="Other(อื่นๆ)" @if(in_array('Other(อื่นๆ)', $selectedPrograms)) selected @endif>Other(อื่นๆ)</option>
								</select>

								@error('program')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
							</div>
							
							<div class="form-group has-label">
                                <label>ประเภทการให้บริการ</label>
                                <select id="service_type" name="service_type" class="form-control">
                                    <option value="">--เลือกข้อมูล--</option>
									<?php
										foreach($ServiceType as $svt){
											$selected = $data->service_type == $svt ? 'selected' : '';
									?>
                                    <option value="<?php echo $svt; ?>" <?php echo $selected; ?>><?php echo $svt; ?></option>
									<?php
										}
									?>
                                </select>
                                @error('service_type')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
							<div class="form-group has-label">
                                <label>ช่องทางที่ให้บริการ</label>
                                <select id="service_channel" name="service_channel" class="form-control">
                                    <option value="">--เลือกข้อมูล--</option>
									<?php
										foreach($ServiceChannel as $svc){
											$selected = $data->service_channel == $svc ? 'selected' : '';
									?>
                                    <option value="<?php echo $svc; ?>" <?php echo $selected; ?>><?php echo $svc; ?></option>
									<?php
										}
									?>
                                </select>
                                @error('service_channel')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
							
							<div class="form-group has-label">
								<label>ช่องทางแจ้งรับบริการ</label>

								@php
									$requestChannelValue = old('request_channel', $data->request_channel ?? '');
									$requestChannelOptions = $requestChannelType ?? [];

									if (!empty($requestChannelValue) && !in_array($requestChannelValue, $requestChannelOptions)) {
										$requestChannelOptions[$requestChannelValue] = $requestChannelValue;
									}
								@endphp

								<input
									type="text"
									id="request_channel"
									name="request_channel"
									class="form-control"
									list="request_channel_list"
									value="{{ $requestChannelValue }}"
									placeholder="พิมพ์หรือเลือกช่องทางแจ้งรับบริการ"
									autocomplete="off"
								>

								<datalist id="request_channel_list">
									@foreach($requestChannelOptions as $rqc)
										<option value="{{ $rqc }}">
									@endforeach
								</datalist>

								@error('request_channel')
									<small class="error-danger-text">{{ $message }}</small>
								@enderror
							</div>
							
							<div class="form-group has-label">
                                <label>แผนก</label>
                                <select id="department" name="department" class="form-control">
                                    <option value="">--เลือกข้อมูล--</option>
									<?php
										foreach($department as $dp){
											$selected = $data->department == $dp ? 'selected' : '';
									?>
                                    <option value="<?php echo $dp; ?>" <?php echo $selected; ?>><?php echo $dp; ?></option>
									<?php
										}
									?>
                                </select>
                                @error('department')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
							
                            <div class="form-group">
                                <label>Note.</label>
                                <textarea rows="5" class="form-control" id="note" name="note"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('ticket.index')}}">
                                        @include('layouts.admin._button.back')
                                    </a>
                                </div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection


@section('js')
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- select2-bootstrap4-theme -->
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
    <!-- ckeditor 4 -->
    <script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>

    <script>
        CKEDITOR.replace( 'editor');
    </script>

@endsection
