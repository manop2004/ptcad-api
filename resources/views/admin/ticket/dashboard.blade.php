@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<form id="TicketDashboardForm" name="TicketDashboardForm" method="get" action="{{ route('ticket.dashboard') }}" style="margin-bottom: 0px;">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				
				<select id="staffId" name="staffId" class="form-control" onchange="submitForm()">
					<option value="">-- All Staff --</option>
					@foreach ($usersSupport as $users)
						<option value="{{ $users->id }}" @if($users->id == $staffId)selected="selected"@endif>{{ $users->name.' '.$users->lastname }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<input 
					type="date" 
					id="date_start" 
					name="date_start" 
					class="form-control" 
					value="{{ request('date_start') }}" 
					onchange="submitForm()" 
				/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<input 
					type="date" 
					id="date_end" 
					name="date_end" 
					class="form-control" 
					value="{{ request('date_end') }}" 
					onchange="submitForm()" 
				/>
			</div>
		</div>
	</div>
</form>

<div class="row">
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-primary"><i class="fa fa-envelope text-primary"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">NEW</p>
                            <p class="card-title"><a href="{{ route('ticket.index',['status' => '1']) }}">@if(!empty($openTicket)){{ number_format($openTicket) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">Total New Ticket</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning"><i class="fa fa-refresh text-warning"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">IN PROGRESS</p>
                            <p class="card-title"><a href="{{ route('ticket.index',['status' => '2', 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($inprogressTicket)){{ number_format($inprogressTicket) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">Total In Progress Ticket</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-success"><i class="nc-icon nc-icon nc-settings text-success"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">RESOLVED</p>
                            <p class="card-title"><a href="{{ route('ticket.index',['status' => '3', 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($closedTicket)){{ number_format($closedTicket) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
					
                    <div class="stats">Total Success Ticket</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-danger"><i class="fa fa-window-close text-danger"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">CANCEL</p>
                            <p class="card-title"><a href="{{ route('ticket.index',['status' => '4', 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($cancelTicket)){{ number_format($cancelTicket) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">Total Cancel Ticket</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="icon-big icon-warning"><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i></div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="numbers">
                            <p class="card-category">FEEDBACK SCORE</p>
                            <p class="card-title">
								@if(!empty($score))
									@foreach ($score as $data_score)
										@php
											$avg_score = 0;
											$count_score = 0;
											if(!empty($data_score->sum_score) && !empty($data_score->count_score)){
												$avg_score = number_format($data_score->sum_score/$data_score->count_score,1);
												$count_score = $data_score->count_score;
											}
										@endphp
										{{ $avg_score }} / 10
									@endforeach
								@endif
							</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">Average Rating from @if(!empty($count_score)){{ $count_score }}@endif คน</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big icon-danger"><i class="fa fa-file text-info"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">ALL TICKET</p>
                            <p class="card-title"><a href="{{ route('ticket.index',['staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($count)){{ number_format($count) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">Total All Ticket</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-6 col-md-2">
                        <div class="icon-big icon-warning"><i class="fa fa-hourglass-half text-warning"></i></div>
                    </div>
                    <div class="col-6 col-md-10">
                        <div class="numbers">
                            <p class="card-category">PICKUP PERIOD</p>
                            <p class="card-title">
								<a href="javascript:void(0)" data-toggle="popover" title="Condition" data-html="true" data-content="<small class='text-danger'>1. จับเวลาจาก สถานะ Open - In Progress</br>2. คำนวนเฉพาะ Ticket ที่เปิดในวันทำการ จันทร์-ศุกร์ เวลา 08.30-17.00 น.<br/>3. ไม่รวมช่วงเวลาพักเที่ยง 12.00-13.00 น.<br/>4. ไม่รวมวันหยุดบริษัท<br/>5. ไม่รวม Status ที่ Cancel</small>">
									@if(!empty($ticketDurationTime))
									{{ $ticketDurationTime }}
									@endif
								</a>
							</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
						ระยะเวลาเฉลี่ยในการรับเคส

					</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big icon-danger"><i class="fa fa-pencil-square-o text-success"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">ALL ARTICLES</p>
                            <p class="card-title"><a href="{{ route('artlicle.index',['staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($count_article)){{ number_format($count_article) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">จำนวนบทความทั้งหมด</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big icon-danger"><i class="fa fa-eye text-danger"></i></div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">ARTICLE VIEWS</p>
                            <p class="card-title"><a href="{{ route('artlicle.index',['staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">@if(!empty($count_view_article)){{ number_format($count_view_article) }}@endif</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">ยอดเข้าชมบทความทั้งหมด</div>
                </div>
            </div>
        </div>
        
    </div>
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="numbers">
					<p class="card-category">จำนวน Ticket รายเดือน (ไม่รวม Cancel) เทียบปีที่แล้ว</p>
				</div>
			</div>
			<div class="card-body">
				<canvas id="ticketMonthlyChart" height="360"></canvas>
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
	  <div class="card">
		<div class="card-header">
		  <div class="numbers">
			<p class="card-category">ประเภทการให้บริการ (รายเดือน เทียบปีที่แล้ว)</p>
		  </div>
		</div>
		<div class="card-body">
		  <canvas id="serviceTypeStackedChart" height="660"></canvas>
		</div>
	  </div>
	</div>
	
	<div class="col-md-12">
	  <div class="card">
		<div class="card-header">
		  <div class="numbers"><p class="card-category">แผนกที่ให้บริการ</p></div>
		</div>
		<div class="card-body">
		  <canvas id="departmentBarChart" height="360"></canvas>
		</div>
	  </div>
	</div>
	
	<div class="col-md-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">ประเภทการให้บริการ</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_service_type))
								@foreach ($count_service_type as $data_service_type)
									<tr>
										<td><div class="display-inline"><a href="{{ route('ticket.index',['service_type' => $data_service_type->service_type, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_service_type->service_type }}</a></td>
										<td class="right"><a href="{{ route('ticket.index',['service_type' => $data_service_type->service_type, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_service_type->count_service_type }}</a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">Top 10 Account</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ชื่อบริษัท</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_company))
								@foreach ($count_company as $data_company)
									<tr>
										<td><div class="display-inline">{{ $data_company->company }}</div></td>
										<td class="right">{{ $data_company->count_company }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				
				<div class="card-footer right">
					<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="loadData('count_company')">
						ดูทั้งหมด
					</a>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">Top 10 Article</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th class="right">Views</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_topview_article))
    @foreach ($count_topview_article as $data_topview_article)
        <tr>
            @if(!empty($data_topview_article->art_parmalink))
                <td><div class="display-inline"><a href="{{ route('fronend.article.content',['permalink' => $data_topview_article->art_parmalink]) }}" target="_blank">{{ $data_topview_article->art_name }}</a></div></td>
                <td class="right"><a href="{{ route('fronend.article.content',['permalink' => $data_topview_article->art_parmalink]) }}" target="_blank">{{ number_format($data_topview_article->sum_view) }}</a></td>
            @else
                <td><div class="display-inline">{{ $data_topview_article->art_name }}</div></td>
                <td class="right">{{ number_format($data_topview_article->sum_view) }}</td>
            @endif
        </tr>
    @endforeach
@endif
						</tbody>
					</table>
				</div>
				<div class="card-footer right">
					<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="loadData('count_topview_article')">
						ดูทั้งหมด
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">ช่องทางที่ให้บริการ</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_service_channel))
								@foreach ($count_service_channel as $data_service_channel)
									<tr>
										<td><div class="display-inline"><a href="{{ route('ticket.index',['service_channel' => $data_service_channel->service_channel, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_service_channel->service_channel }}</a></td>
										<td class="right"><a href="{{ route('ticket.index',['service_channel' => $data_service_channel->service_channel, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_service_channel->count_service_channel }}</a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!--div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">ผู้แจ้งรับบริการช่วยเหลือ</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_request_by))
								@foreach ($count_request_by as $data_request_by)
									<tr>
										<td><div class="display-inline"><a href="{{ route('ticket.index',['request_by' => $data_request_by->request_by, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_request_by->request_by }}</a></td>
										<td class="right"><a href="{{ route('ticket.index',['request_by' => $data_request_by->request_by, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">{{ $data_request_by->count_request_by }}</a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div-->
		
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">ช่องทางแจ้งรับบริการ</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_request_channel))
								@foreach ($count_request_channel as $data_request_channel)
									<tr>
										<td>
											<div class="display-inline">
												<a href="{{ route('ticket.index',[
													'request_channel' => $data_request_channel->request_channel,
													'staffId' => $staffId,
													'date_start' => $date_start,
													'date_end' => $date_end
												]) }}">
													@if(!empty($data_request_channel->request_channel))
														{{ $data_request_channel->request_channel }}
													@else
														ไม่ได้ระบุ
													@endif
												</a>
											</div>
										</td>
										<td class="right">
											<a href="{{ route('ticket.index',[
												'request_channel' => $data_request_channel->request_channel,
												'staffId' => $staffId,
												'date_start' => $date_start,
												'date_end' => $date_end
											]) }}">
												{{ $data_request_channel->count_request_channel }}
											</a>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<div class="card-footer right">
					<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="loadData('count_request_channel')">
						ดูทั้งหมด
					</a>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">Top 10 Email CC</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_sales))
								@foreach ($count_sales as $data_sales)
									<tr>
										<td><div class="display-inline">{{ $data_sales->email_cc }}</div></td>
										<td class="right">{{ $data_sales->count_sales }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<div class="card-footer right">
					<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="loadData('count_sales')">
						ดูทั้งหมด
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
	
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">แผนก</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>แผนก</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_department))
								@foreach ($count_department as $data_department)
									<tr>
										<td>
											<div class="display-inline">
												<a href="{{ route('ticket.index', [
													'department' => $data_department->department, 
													'staffId' => $staffId, 
													'date_start' => $date_start, 
													'date_end' => $date_end
												]) }}">
													@if(!empty($data_department->department))
														{{ $data_department->department }}
													@else
														ไม่ได้ระบุ
													@endif
												</a>
											</div>
										</td>
										<td class="right">
											<a href="{{ route('ticket.index', [
													'department' => $data_department->department, 
													'staffId' => $staffId, 
													'date_start' => $date_start, 
													'date_end' => $date_end
												]) }}">
												{{ $data_department->count_department }}
											</a>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="numbers">
						<p class="card-category">โปรแกรมที่เกิดปัญหา</p>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th class="right">จำนวน</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($count_program))
								@foreach ($count_program as $data_program)
									<tr>
										<td>
											<div class="display-inline">
												<a href="{{ route('ticket.index', ['program' => $data_program->program_name, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">
													{{ $data_program->program_name }}
												</a>
											</div>
										</td>
										<td class="right">
											<div class="display-inline">
												<a href="{{ route('ticket.index', ['program' => $data_program->program_name, 'staffId' => $staffId, 'date_start' => $date_start, 'date_end' => $date_end]) }}">
													{{ $data_program->count_program }}
												</a>
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

<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">ข้อมูลทั้งหมด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-content"></div> <!-- โหลดข้อมูลที่นี่ -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<!-- Chart.js + DataLabels -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
(function(){
    // register plugin (ทำซ้ำได้ ไม่ error)
    if (typeof ChartDataLabels !== 'undefined') {
        try { Chart.register(ChartDataLabels); } catch(e){}
    }

    const canvas = document.getElementById('ticketMonthlyChart');
    if (!canvas) return;

    // เคลียร์ chart เดิม
    const existing = Chart.getChart(canvas);
    if (existing) existing.destroy();

    const ctx = canvas.getContext('2d');

    const labels = @json($chart_month_labels ?? []);
    const dataCurrent = @json($chart_month_current ?? []);
    const dataPrev = @json($chart_month_prev ?? []);

    window.ticketMonthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                // --- แท่งปีนี้: เขียว + ตัวเลขที่โคนด้านใน (ซ่อนเมื่อ 0) ---
                {
                    type: 'bar',
                    label: 'ปีนี้/ช่วงที่เลือก',
                    data: dataCurrent,
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                    datalabels: {
                        display: (ctx) => (ctx.raw !== 0),     // ซ่อนเมื่อเป็น 0
                        anchor: 'start',     // ฐานแท่ง
                        align:  'end',       // วางด้านในเหนือฐาน
                        offset: 2,
                        clip: true,
                        clamp: true,
                        color: '#ffffff',
                        formatter: (v) => (v === 0 ? null : v),
                        font: { weight: 'bold' }
                    }
                },
                // --- เส้นปีที่แล้ว: เทา + ตัวเลขสีแดง danger (ซ่อนเมื่อ 0) ---
                {
                    type: 'line',
                    label: 'ปีที่แล้ว',
                    data: dataPrev,
                    borderColor: '#9CA3AF',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 3,
                    tension: 0.2,
                    yAxisID: 'y',
                    datalabels: {
                        display: (ctx) => (ctx.raw !== 0),     // ซ่อนเมื่อเป็น 0
                        anchor: 'end',
                        align:  'top',
                        offset: 4,
                        color: '#dc3545',   // แดง danger
                        formatter: (v) => (v === 0 ? null : v)
                    }
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(ctx){
                            const label = ctx.dataset.label || '';
                            const v = ctx.parsed.y ?? ctx.raw;
                            return `${label}: ${v.toLocaleString()}`;
                        }
                    }
                },
                datalabels: { display: true } // ค่าพื้นฐาน (จะถูก dataset override)
            },
            scales: {
                x: { ticks: { autoSkip: true, maxRotation: 0 } },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        callback: (v) => Number(v).toLocaleString()
                    }
                }
            }
        }
    });
})();
</script>

<script>
(function () {
  const el = document.getElementById('departmentBarChart');
  if (!el) return;

  if (typeof ChartDataLabels !== 'undefined') {
    try { Chart.register(ChartDataLabels); } catch(e){}
  }

  // เคลียร์ของเดิม
  const old = Chart.getChart(el);
  if (old) old.destroy();

  const labels = @json($dept_labels ?? []);
  const values = @json($dept_values ?? []);
  const total  = values.reduce((a,b)=>a+b, 0);

  // ปรับความสูงอัตโนมัติให้พอดีกับจำนวนแผนก (ประมาณ 28px ต่อแถว)
  el.height = Math.max(240, labels.length * 28);

  const ctx = el.getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'จำนวน',
        data: values,
        backgroundColor: 'rgba(59,130,246,0.75)',  // ฟ้า
        borderColor: 'rgba(59,130,246,1)',
        borderWidth: 1,
        borderSkipped: false
      }]
    },
    options: {
      indexAxis: 'y',               // ← ทำให้เป็นแนวนอน
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: (ctx) => {
              const v = ctx.parsed.x ?? ctx.raw;
              const pct = total ? (v * 100 / total) : 0;
              return ` ${v.toLocaleString()} (${pct.toFixed(1)}%)`;
            }
          }
        },
        datalabels: {
          display: true,            // ✅ โชว์ตัวเลขทุกแท่ง
          anchor: 'end',
          align: 'right',
          offset: 6,
          clamp: true,
          color: '#111827',
          backgroundColor: 'rgba(255,255,255,0.9)',
          borderColor: 'rgba(0,0,0,0.15)',
          borderWidth: 1,
          borderRadius: 4,
          padding: {top: 2, right: 6, bottom: 2, left: 6},
          formatter: (v, ctx) => {
            const pct = total ? (v * 100 / total) : 0;
            return `${Number(v).toLocaleString()} (${pct.toFixed(1)}%)`;
          },
          font: (ctx) => {
            const w = ctx.chart.width;
            return { weight: 'bold', size: Math.max(10, Math.min(13, Math.round(w/50))) };
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          ticks: { precision: 0, callback: v => Number(v).toLocaleString() },
          grid: { drawBorder: false }
        },
        y: {
          ticks: { autoSkip: false, maxRotation: 0 },
          grid: { display: false }
        }
      }
    }
  });
})();
</script>



<script>
(function () {
  const el = document.getElementById('serviceTypeStackedChart');
  if (!el) return;

  // register ปลั๊กอิน (เผื่อยังไม่ได้)
  if (typeof ChartDataLabels !== 'undefined') {
    try { Chart.register(ChartDataLabels); } catch(e){}
  }

  // ล้างกราฟเดิม
  const old = Chart.getChart(el);
  if (old) old.destroy();

  const labels   = @json($stack_labels ?? []);
  const types    = @json($stack_types ?? []);
  const dataCurr = @json($stack_curr ?? []);
  const dataPrev = @json($stack_prev ?? []);

  const ctx = el.getContext('2d');

  // พาเลทสี (วนซ้ำได้)
  const PALETTE = [
    '#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#a855f7',
    '#06b6d4', '#84cc16', '#d946ef', '#f97316', '#10b981'
  ];
  const hexToRgba = (hex, a) => {
    const v = hex.replace('#','');
    const r = parseInt(v.slice(0,2),16);
    const g = parseInt(v.slice(2,4),16);
    const b = parseInt(v.slice(4,6),16);
    return `rgba(${r},${g},${b},${a})`;
  };

  // formatter: แสดงเฉพาะค่าที่เป็นตัวเลขและไม่เท่ากับ 0
  const fmt = (val) => {
    const n = Number(val);
    return (Number.isFinite(n) && n !== 0) ? n.toLocaleString() : null; // null = ไม่วาด
  };

  const datasets = [];
  types.forEach((t, idx) => {
    const name = t && t.length ? t : 'ไม่ได้ระบุ';
    const base = PALETTE[idx % PALETTE.length];

    // ------ ปีนี้ (stack: curr) ------
    datasets.push({
      type: 'bar',
      label: `${name} (ปีนี้)`,
      stack: 'curr',
      data: dataCurr[t] || new Array(labels.length).fill(0),
      backgroundColor: hexToRgba(base, 0.75),
      borderColor:     hexToRgba(base, 1),
      borderWidth: 1,
      datalabels: {
        display: true,              // เปิดไว้ แล้วคุมการซ่อนด้วย formatter
        anchor:  'center',          // คงตำแหน่งเดิม
        align:   'center',          // คงตำแหน่งเดิม
        color:   '#ffffff',
        formatter: fmt,
        font: { weight: 'bold' },
        clip: true, clamp: true
      }
    });

    // ------ ปีที่แล้ว (stack: prev) ------
    datasets.push({
      type: 'bar',
      label: `${name} (ปีที่แล้ว)`,
      stack: 'prev',
      data: dataPrev[t] || new Array(labels.length).fill(0),
      backgroundColor: hexToRgba(base, 0.35),
      borderColor:     hexToRgba(base, 0.8),
      borderWidth: 1,
      datalabels: {
        display: true,              // เปิดไว้ แล้วคุมการซ่อนด้วย formatter
        anchor:  'center',
        align:   'center',
        color:   '#111827',
        formatter: fmt,
        font: { weight: 'bold' },
        clip: true, clamp: true
      }
    });
  });

  window.serviceTypeStackedChart = new Chart(ctx, {
    type: 'bar',
    data: { labels, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top' },
        tooltip: {
          mode: 'index',
          intersect: false,
          callbacks: {
            label: (ctx) => {
              const v = ctx.parsed.y ?? ctx.raw;
              return `${ctx.dataset.label}: ${Number(v).toLocaleString()}`;
            }
          }
        },
        // ✅ เปิดปลั๊กอินระดับกราฟไว้
        datalabels: { display: true }
      },
      scales: {
        x: { stacked: true, ticks: { autoSkip: true, maxRotation: 0 } },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: { precision: 0, callback: (v)=>Number(v).toLocaleString() }
        }
      }
    }
  });
})();
</script>



<script>

	function submitForm(){
		$('#TicketDashboardForm').submit();
	}
	
	function loadData(type) {
        $('#modal-content').html('<p class="text-center">กำลังโหลดข้อมูล...</p>');
		var staffId = $('#staffId').val() || '';
		var date_start = $('#date_start').val() || '';
		var date_end = $('#date_end').val() || '';

        $.ajax({
            url: '{{ route("ticket.getAllData") }}',
            type: 'GET',
            data: {
				type: type,
				staffId: staffId,
				date_start: date_start,
				date_end: date_end
			},
            success: function(response) {
                $('#modal-content').html(response);
                $('#dataModal').modal('show');
            },
            error: function(xhr) {
                $('#modal-content').html('<p class="text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</p>');
            }
        });
    }
</script>
@endsection
