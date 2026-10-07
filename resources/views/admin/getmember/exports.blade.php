<table>
    <thead>
        <tr>
            <th style="text-align: left">No.</th>
            <th width="30"style="text-align: left">ชื่อ - นามสกุล</th>
            <th width="30"style="text-align: left">เบอร์โทรศัพท์</th>
            <th width="30"style="text-align: left">อีเมล์</th>
            <th width="30"style="text-align: left">ที่อยู่</th>
            <th width="20"style="text-align: left">ตำบล</th>
            <th width="20"style="text-align: left">อำเภอ</th>
            <th width="20"style="text-align: left">จังหวัด</th>
            <th width="20"style="text-align: left">รหัสไปรษณีย์</th>
            <th width="30" style="text-align: left">สถานะ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $user )
            <tr>
                <td style="text-align: left">{{$i++}}</td>
                <td style="text-align: left">{{$user->name}} {{$user->lastname}}</td>
                <td style="text-align: left">{{$user->tel}}</td>
                <td style="text-align: left">{{$user->email}}</td>
                <td style="text-align: left">{{$user->address}}</td>
                <td style="text-align: left">{{$user->dis_name_th}}</td>
                <td style="text-align: left">{{$user->amp_name_th}}</td>
                <td style="text-align: left">{{$user->prov_name_th}}</td>
                <td style="text-align: left">{{$user->zipcode}}</td>
                @if($user->status == 1)
                    <td style="text-align: left">จัดส่งของขวัญแล้ว</td>
                @else
                    <td style="text-align: left">ยังไม่จัดส่งของขวัญ</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>