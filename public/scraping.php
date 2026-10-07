<?php
// กำหนดที่อยู่สำหรับเก็บ Cookie (ไฟล์นี้จะเก็บ cookie จาก session)
$cookieFile = 'cookie.txt';

// กำหนด cookie ที่คุณคัดลอกมาจาก Browser หลังจากเข้าสู่ระบบ (ถ้ามี)
$manualCookie = "XSRF-TOKEN=eyJpdiI6IkdyT3dHMkZpK05pNWlOZjV3TmJReFE9PSIsInZhbHVlIjoidk81SGlBeThKRCtiZnpxaXNNOFU0ZlpQSWZzd2ErcWg2YjVcL1FoRStBZzVnWUZXXC9FYlE5RjFOTWdVZ0RCOXpPZ2p1NktaXC9CV2FYZUFIR2hlWElHRHc9PSIsIm1hYyI6ImE0ZDhjYjRjN2RmNWVkMWU2OWExYWY3ODdhODE4ZmU4YTI3ZmFjMThjNjQ0ZGMxMmViYmViNDdmOTVjNTBmNTMifQ%3D%3D; laravel_session=eyJpdiI6IlRjRWpNY25tWDgzbWZkWldVc3NxSnc9PSIsInZhbHVlIjoiTVwvTEpWWE9Hck93dFVXdVNtT1A1SzFhRjBLSWVoQk1sSTl0Y2lJTlVLVE1aMnhGSmVZUjRONTVzMkhLRVJhcDJuaXhqNnlJRm9oMThvU1A4RjBIZ2tnPT0i";

// *******************************
// ขั้นตอนที่ 1: GET Request เพื่อรับ Session
// *******************************
$getUrl = 'http://membermrs.act.or.th/check-juristic-licence';

$ch = curl_init($getUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// ให้ cURL เก็บ cookie ลงในไฟล์
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36');
$responseGet = curl_exec($ch);
if (curl_errno($ch)) {
    die("GET cURL error: " . curl_error($ch));
}
curl_close($ch);

// พยายามดึง CSRF token จาก meta tag (ถ้ามี)
$csrfToken = '';
if (preg_match('/<meta\s+name=["\']csrf-token["\']\s+content=["\']([^"\']+)["\']/i', $responseGet, $matches)) {
    $csrfToken = $matches[1];
} else {
    // หากไม่พบใน HTML ให้สกัดจาก cookie ที่เราคัดลอกมาเอง
    if (preg_match('/XSRF-TOKEN=([^;]+)/', $manualCookie, $matches)) {
         $csrfToken = urldecode($matches[1]);
    } else {
         die("ไม่พบ CSRF token จากหน้า HTML และ cookie");
    }
}

echo "CSRF Token: " . htmlspecialchars($csrfToken) . "<br>\n";

// *******************************
// ขั้นตอนที่ 2: POST Request เพื่อดึงข้อมูล JSON
// *******************************
$postUrl = 'http://membermrs.act.or.th/check-juristic-licence';

// เตรียม JSON payload สำหรับค้นหา
$data = [
    "searchText" => "",
    "page" => 0
];
$jsonData = json_encode($data);

$ch = curl_init($postUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// ใช้ cookie จากไฟล์เดียวกัน (session ที่ GET มาก่อน)
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

// นอกจากนี้ แนบ cookie จาก $manualCookie ด้วย เพื่อความแน่นอน
$combinedCookie = $manualCookie;

// ตั้งค่า HTTP Header พร้อมแนบ CSRF token ที่ได้มา
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    "X-CSRF-TOKEN: $csrfToken",
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
    "Cookie: $combinedCookie"
]);
// ระบุ Referer ให้ตรงกับ URL ที่เรา GET มาก่อนหน้านี้
curl_setopt($ch, CURLOPT_REFERER, $getUrl);

$responsePost = curl_exec($ch);
if (curl_errno($ch)) {
    die("POST cURL error: " . curl_error($ch));
}
curl_close($ch);

// สำหรับ debugging: แสดง raw response
echo "<pre>Raw POST Response:\n";
echo htmlspecialchars($responsePost);
echo "\n</pre>";

// *******************************
// ขั้นตอนที่ 3: แปลง JSON และแสดงผลในรูปแบบตาราง
// *******************************
$resultArray = json_decode($responsePost, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("เกิดข้อผิดพลาดในการ decode JSON: " . json_last_error_msg());
}

// ตรวจสอบว่ามีข้อมูลใน key 'results'
if (!isset($resultArray['results']) || empty($resultArray['results'])) {
    die("ไม่มีข้อมูลในส่วนของ results");
}

$results = $resultArray['results'];

// แสดงผลข้อมูลที่ต้องการ: เลขที่ใบอนุญาตฯ, ชื่อบริษัท, วันที่หมดอายุ, กรรมการ
echo "<table border='1' cellspacing='0' cellpadding='5'>";
echo "<tr>
        <th>เลขที่ใบอนุญาตฯ</th>
        <th>ชื่อบริษัท</th>
        <th>วันที่หมดอายุ</th>
        <th>กรรมการ</th>
      </tr>";

foreach ($results as $item) {
    // เลือกใช้เลขที่ใบอนุญาต (ในที่นี้ใช้ LicenceNumberText)
    $licenceNumber = isset($item['LicenceNumberText']) ? $item['LicenceNumberText'] : '';
    
    // ชื่อบริษัท: ใช้ชื่อภาษาไทยก่อน ถ้าไม่มีให้ใช้ชื่อภาษาอังกฤษ
    $companyName = (isset($item['NameTH']) && !empty($item['NameTH']))
                    ? $item['NameTH']
                    : (isset($item['NameEN']) ? $item['NameEN'] : '');
    
    // วันที่หมดอายุ (EndDate)
    $endDate = isset($item['EndDate']) ? $item['EndDate'] : '';
    
    // ดึงข้อมูลกรรมการจาก array 'shares'
    $directors = [];
    if (isset($item['shares']) && is_array($item['shares'])) {
        foreach ($item['shares'] as $share) {
            $directorName = "";
            if (isset($share['TitleName'])) {
                $directorName .= $share['TitleName'] . " ";
            }
            if (isset($share['FirstName'])) {
                $directorName .= $share['FirstName'] . " ";
            }
            if (isset($share['LastName'])) {
                $directorName .= $share['LastName'];
            }
            $directors[] = trim($directorName);
        }
    }
    $directorsStr = implode(", ", $directors);
    
    echo "<tr>";
    echo "<td>" . htmlspecialchars($licenceNumber) . "</td>";
    echo "<td>" . htmlspecialchars($companyName) . "</td>";
    echo "<td>" . htmlspecialchars($endDate) . "</td>";
    echo "<td>" . htmlspecialchars($directorsStr) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
