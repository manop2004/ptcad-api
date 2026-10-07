<div style="background-color:#F5F5F5; padding:10px;">
    <div style="border:solid #CCCCCC 1px; padding:10px; background-color:#FFFFFF; text-align:left;border-radius: 15px;">
        <p>[8BAHT.COM] - : <strong>@if(!empty($data->campaignname )){{ $data->campaignname }}@endif</strong></p>
        <p>รายละเอียดของลูกค้า
            <br /> รหัส : @if(!empty($data->no )){{ $data->no }}@endif
            <br /> ชื่อ : @if(!empty($data->result['firstname'] )){{ $data->result['firstname'] }}@endif @if(!empty($data->result['lastname'] )){{ $data->result['lastname'] }}@endif
            <br /> อีเมลล์ : @if(!empty($data->result['email'])){{ $data->result['email'] }}@endif
            <br /> อาชีพ: @if(!empty($data->result['designation'])){{ $data->result['designation'] }}@endif
            <br /> บริษัท : @if(!empty($data->result['company'])){{ $data->result['company'] }}@endif
            <br /> ที่อยู่ : @if(!empty($data->result['lane'])){{ $data->result['lane'] }}@endif
            <br /> เมือง : @if(!empty($data->result['city'])){{ $data->result['city'] }}@endif
            <br /> จังหวัด : @if(!empty($data->result['cf_650'])){{ $data->result['cf_650'] }}@endif
            <br /> รหัสไปรษณีย์ : @if(!empty($data->result['code'])){{ $data->result['code'] }}@endif
            <br /> มือถือ : @if(!empty($data->result['mobile'])){{ $data->result['mobile'] }}@endif
            <br /> Lead status : <strong>@if(!empty($data->result['leadstatus'])){{$data->result['leadstatus'] }}@endif</strong>
            <br /> leads filter : <strong>@if(!empty($data->result['cf_842'])){{ $data->result['cf_842'] }}@endif</strong>
            <br /> รายละเอียดเพิ่มเติม
            <br /> @if(!empty($data->result['description'])){{ nl2br($data->result['description']) }}@endif
            <br /> Urlreference : @if(!empty($data->result['cf_659'])){{ $data->result['cf_659'] }}@endif
        </p>
        <p>คลิกดูรายละเอียด <br />
            <a href="https://appcrm.applicadthai.com/m.php?module=Leads&action=DetailView&record=@if(!empty($data->id)){{ $data->id }}@endif">
                https://appcrm.applicadthai.com/m.php?module=Leads&action=DetailView&record=@if(!empty($data->id)){{ $data->id }}@endif
            </a>
        </p>
        @if(!empty($data->description))
        <p>
            {{ $data->description }}
        </p>
        @endif
        <p>
        www.8baht.com
        </p>
    </div>
    <p>* This email was sent automatically from system. You can not reply to this email.</p>
</div>
