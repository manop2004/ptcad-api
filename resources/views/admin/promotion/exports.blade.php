<table>
    <thead>
        <tr>
            <th style="text-align: left">No.</th>
            <th style="width: 30px; text-align: left">ชื่อ - นามสกุล</th>
            <th style="width: 50px; text-align: left">เบอร์โทรศัพท์</th>
            <th style="width: 50px; text-align: left">อีเมล</th>
            <th style="width: 50px; text-align: left">รับข้อมูลข่าวสารและประชาสัมพันธ์</th>
            <th style="width: 50px; text-align: left">บข้อมูลข่าวสารเกี่ยวกับบริษัท/บทความ</th>
            <th style="width: 50px; text-align: left">รับข้อมูลข่าวสารเกี่ยวกับสินค้าและบริการของบริษัท</th>
        </tr>
    </thead>
    <tbody>
        @if(count($data) != 0)
            @foreach ($data as $key=> $user)
                <tr>
                    <td style="text-align: left">{{$i++}}</td>
                    <td style="width: 250px; text-align: left">{{$user->fullname}}</td>
                    <td style="width: 250px; text-align: left">{{$user->tel}}</td>
                    <td style="width: 250px; text-align: left">{{$user->email}}</td>
                    <td style="width: 250px; text-align: left">@if($user->pdpa_news == 1){{ 'อนุญาต' }}@else{{ 'ไม่อนุญาต' }}@endif</td>
                    <td style="width: 250px; text-align: left">@if($user->pdpa_article == 1){{ 'อนุญาต' }}@else{{ 'ไม่อนุญาต' }}@endif</td>
                    <td style="width: 250px; text-align: left">@if($user->pdpa_product == 1){{ 'อนุญาต' }}@else{{ 'ไม่อนุญาต' }}@endif</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>