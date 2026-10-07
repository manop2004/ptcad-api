@if($type == 'count_company')
    <h5>ข้อมูลบริษัททั้งหมด</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อบริษัท</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data) && count($data))
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->company }}</td>
                        <td>{{ $row->count_company }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @endif
        </tbody>
    </table>

@elseif($type == 'count_sales')
    <h5>อีเมลที่ใช้บ่อย</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data) && count($data))
                @foreach($data as $row)
                    <tr>
                        <td>
                            @if(!empty($row->email_cc))
                                {{ $row->email_cc }}
                            @else
                                ไม่ได้ระบุ
                            @endif
                        </td>
                        <td>{{ $row->count_sales }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @endif
        </tbody>
    </table>

@elseif($type == 'count_topview_article')
    <h5>บทความที่มีผู้เข้าชมมากที่สุด</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อบทความ</th>
                <th>จำนวนการเข้าชม</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data) && count($data))
                @foreach($data as $row)
                    <tr>
                        <td>
                            <a href="{{ route('fronend.article.content', ['permalink' => $row->art_parmalink]) }}" target="_blank">
                                {{ $row->art_name }}
                            </a>
                        </td>
                        <td>{{ $row->sum_view }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @endif
        </tbody>
    </table>

@elseif($type == 'count_request_channel')
    <h5>ช่องทางแจ้งรับบริการทั้งหมด</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ช่องทางแจ้งรับบริการ</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data) && count($data))
                @foreach($data as $row)
                    <tr>
                        <td>
                            @if(isset($row->request_channel) && $row->request_channel !== '')
                                {{ $row->request_channel }}
                            @else
                                ไม่ได้ระบุ
                            @endif
                        </td>
                        <td>{{ $row->count_request_channel }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @endif
        </tbody>
    </table>

@else
    <div class="text-center">ไม่พบข้อมูล</div>
@endif