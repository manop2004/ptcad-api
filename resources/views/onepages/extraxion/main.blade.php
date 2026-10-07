@extends('layouts.onepages.extraxion._template')

@section('content')
<div class="content-wrap">
    <div id="block-slider">
        <div class="container clearfix">
            <div class="row">
                <div class="col-md-6">
                    <a href="https://service-app.synology.me:5001/sharing/i6vSzFOs2" target="_bank">
                        <img width="555" height="380" class="full-width slider-item-1 lazyload hidden-sm hidden-xs" loading="lazy" data-src="{{ asset('onepages/extraxion/images/slider-1.webp') }}" />
                        <img width="555" height="524" class="full-width slider-item-1 lazyload hidden-lg hidden-md" loading="lazy" data-src="{{ asset('onepages/extraxion/images/slider-3.webp') }}" />
                    </a>
                </div>
                <div class="col-md-6 slider-padding-top">
                    <img width="555" height="456" class="full-width slider-item-1 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/slider-2-v2.webp') }}" />
                </div>
            </div>
        </div>
    </div>
    <div id="block-01">
        <div class="container clearfix padding-block">
            <div class="row bottommargin-sm">
                <div class="col-md-2 col-sm-3 center">
                    <img width="165" height="109" class="full-width slider-item-3 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/ExtrAXION.webp') }}" />
                </div>
                <div class="col-md-10 col-sm-9">
                    ซอฟต์แวร์ถอดปริมาณที่ช่วยลดเวลาและขั้นตอนสำหรับงานก่อสร้าง สถาปัตยกรรมและอื่นๆ ด้วยคำสั่งที่ยืดหยุ่น โปรแกรมสามารถถอดพื้นที่ ความยาว ปริมาตรกับรูปทรงทุกประเภท สามารถถอดปริมาณจากไฟล์ภาพ (BMP, GIF, JPG,TIF และอื่นๆ) จากไฟล์ CAD (DWG, DXF,DGN, DWF,EMF และอื่นๆ)   และโปรแกรมสามารถถอดปริมาณจากไฟล์ PDF ได้เช่นกัน
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 center">
                    <img width="555" height="345" class="full-width slider-item-4 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/ExtrAXION-2D.webp') }}" />
                    <h3 class="nobottommargin topmargin-sm">ExtrAXION 2D</h3>
                    <div class="co-0391df ">ถอดปริมาณงานก่อสร้าง พื้นที่ ขนาดพื้นที่</div>
                </div>
                <div class="col-md-6 slider-padding-top center">
                    <img width="555" height="345" class="full-width slider-item-5 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/ExtrAXION-Rebars.webp') }}" />
                    <h3 class="nobottommargin topmargin-sm">ExtrAXION Rebars</h3>
                    <div class="co-0391df ">"ถอดปริมาณโครงสร้างเหล็กเสริม" ได้ทุกประเภท</div>
                </div>
            </div>
        </div>
    </div>
    <div id="block-02">
        <div class="container clearfix padding-block">
            <div class="row bg-block ">
                <div class="col-lg-6 col-md-5 hidden-sm hidden-xs">
                    <img class="position lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/quotation-layout.webp') }}" />
                </div>
                <div class="col-lg-6 col-md-7 slider-padding-top padding-quotation">
                    <form id="request-quotation" name="request-quotation" method="get" class="nobottommargin" action="{{ route('onepage.extraxion.crate') }}">
                        @csrf
                        <h2 class="co-fff nobottommargin center">รับข้อเสนอสุดพิเศษ</h2>
                        <div class="co-fff center">โปรแกรมช่วยงานธุรกิจก่อสร้าง ราคาเริ่มต้นเพียง 13,408.-*</div>
                        <div class="row topmargin-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small class="co-fff" >ชื่อผู้ติดต่อ *</small>
                                    <input type="text" class="form-control" placeholder="ชื่อ" id="firstname" name="firstname" value="{{ old('firstname') }}">
                                    @error('firstname')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small class="co-fff" >ตำแหน่ง *</small>
                                    <input type="text" class="form-control" placeholder="ตำแหน่ง" id="designation" name="designation"  value="{{ old('designation') }}">
                                    @error('designation')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <small class="co-fff" >ชื่อบริษัท (ถ้ามีกรอกเป็นภาษาอังกฤษเท่านั้น!)</small>
                                    <input type="text" class="form-control" placeholder="ชื่อบริษัท" id="company" name="company"  value="{{ old('company') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small class="co-fff" >เบอร์โทรศัพท์ *</small>
                                    <input type="tel" class="form-control" placeholder="เบอร์โทรศัพท์ *" id="mobile" name="mobile"  value="{{ old('mobile') }}">
                                    @error('mobile')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small class="co-fff" >อีเมลธุรกิจ *</small>
                                    <input type="text" class="form-control" placeholder="อีเมลธุรกิจ *" id="email" name="email"  value="{{ old('email') }}">
                                    @error('email')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <small class="co-fff" >ข้อความถึงเรา (ถ้ามี)</small>
                                    <textarea class="form-control" placeholder="ข้อความ" icols="60" rows="3" id="comment" name="description[message]">{{ old('comment') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="co-fcc841">เลือกโปรแกรมที่ท่านต้องการ</div>
                                </div>
                                <div class="form-group gd-form-check2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="description[ExtrAXION-2D]" id="inlineCheckbox1" value="ExtrAXION 2D | ถอดปริมาณงานก่อสร้าง พื้นที่ ขนาดพื้นที่ ">
                                        <label class="form-check-label co-fff" for="inlineCheckbox1">ExtrAXION 2D | ถอดปริมาณงานก่อสร้าง พื้นที่ ขนาดพื้นที่ </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="description[ExtrAXION-Rebars]" id="inlineCheckbox2" value="ExtrAXION Rebars | ถอดปริมาณโครงสร้างเหล็กเสริม ได้ทุกประเภท ">
                                        <label class="form-check-label co-fff" for="inlineCheckbox2">ExtrAXION Rebars | ถอดปริมาณโครงสร้างเหล็กเสริม ได้ทุกประเภท </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group center">
                                    <input type="hidden" name="campaignid" value="1382582" />
                                    <input type="hidden" name="mailtoteam" value="LDP-Extraxion_8baht" />
                                    <input type="hidden" name="regis_type" value="quotation" />
                                    <input type="hidden" name="pages" value="extraxion" />
                                    <input type="hidden" name="checkemail" value="true" />
                                    <input type="hidden" name="assigned" value="446" />
                                    <input  type="hidden" name="url_path" value="{{ "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" />
                                    <input type="hidden" name="redirect" value="{{ 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] }}"/>
                                    <input type="hidden" name="og_keywords" value="โปรแกรมถอดแบบ,ExtrAXION,ประมาณราคา" />
                                    <input type="hidden" name="og_description" value="โปรแกรมถอดแบบ ประมาณราคา แม่นยำ รวดเร็ว รองรับไฟล์รูปภาพ, PDF และ CAD หมดปัญหา ทำข้อมูล เพื่อประมูลงานไม่ทัน หรือ ประมาณราคาผิดพลาด เช่น เผื่อมากไป ไม่ได้งาน หรือ เผื่อน้อยไป กำไรน้อย/ขาดทุน..." />
                                    <input type="hidden" name="og_image" value="{{ asset('onepages/extraxion/images/ExtrAXION.webp') }}" />
                                    <input  type="hidden" name="urlreference" @if(!empty($_GET["ref"]))value="{{ $_GET["ref"] }}"@endif >
                                    <button id="btn-submit" type="submit" class="loadding bth btn-submit btn-lg btn-block btn-quotation g-recaptcha" data-sitekey="6Le53ssZAAAAAPL3FAcWOt6CxB-AKPe6xKovHqHD" data-callback='onSubmit' data-action='submit' name="submit" ></button>
                                    <small class="co-fff">เมื่อท่านส่งข้อมูลผ่านฟอร์ม จะถือว่าท่านยอมรับใน <a class="co-fcc841" href="https://phpstack-1646968-6541058.cloudwaysapps.com/privacy-policy/">นโยบายความเป็นส่วนตัว</a>ของเรา</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="block-03">
        <div class="tabs clearfix" id="tab-3">
            <div class="container clearfix padding-block">
                <ul class="tab-nav tab-nav2 clearfix">
                    <li class="bl-extraxion-2d"><a href="#extraxion-2d">ExtrAXION 2D</a></li>
                    <li class="bl-extraxion-rebars"><a href="#extraxion-rebars">ExtrAXION Rebars</a></li>
                </ul>
            </div>
            <div class="tab-container">
                <div class="tab-content clearfix" id="extraxion-2d">
                    <div class="container clearfix padding-block">
                        <h3 class="bottommargin-sm border-bottom-2d center">ExtrAXION 2D</h3>
                        <div class="center" >ซอฟต์แวร์ถอดปริมาณที่ช่วยลดเวลาและขั้นตอนสำหรับงานก่อสร้าง สถาปัตยกรรมและอื่นๆ ด้วยคำสั่งที่ยืดหยุ่น โปรแกรมสามารถถอดพื้นที่ ความยาว ปริมาตรกับรูปทรงทุกประเภท สามารถถอดปริมาณจากไฟล์ภาพ (BMP, GIF, JPG,TIF และอื่นๆ) จากไฟล์ CAD (DWG, DXF,DGN, DWF,EMF และอื่นๆ) และโปรแกรมสามารถถอดปริมาณจากไฟล์ PDF ได้เช่นกัน</div>
                    </div>
                    <div class="bg-f3f3f3">
                        <div class="container clearfix padding-block">
                            <div class="row">
                                <div class="col-md-8 bottommargin-sm">
                                    <h2>Organize</h2>
                                    <p>
                                        <div><strong>Build a flexible folder-like layout</strong></div>
                                        <div>สร้างหมวดการถอดปริมาณ เข้าใจง่าย แบ่งตามชื่อและยังเพิ่ม ลดได้ตลอดเวลา</div>
                                    </p>
                                    <p>
                                        <div><strong>Add as many as required measurement sheets</strong></div>
                                            <div>แต่ละไฟล์แบบแปลน สามารถเปิดซ้อนกันได้และยัง Copy Paste ปริมาณดังกล่าวไปยังหมวดอื่น เพื่อความรวดเร็ว ไม่ต้องทำซ้ำ</div>
                                    </p>
                                    <p>
                                        <div><strong>Measurement are grouped into sheets</strong></div>
                                            <div>เช่น หมวดงานสถาปัตฯ หมวดงานไฟฟ้า หมวดงานระบบ สามารถจัดเป็นหมวดหมู่ เพื่อการคำนวณที่ถูกต้องและหาง่าย</div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img width="360" height="380" class="full-width slider-item-6 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/itme-Organize.webp') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <div class="row">
                            <div class="col-md-4 bottommargin-sm">
                                <img width="360" height="284" class="full-width slider-item-7 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/item-Measure.webp') }}" />
                            </div>
                            <div class="col-md-8">
                                <h2>Measure</h2>
                                <p>
                                    <div><strong>The four basic 2d measurement types</strong></div>
                                    <div>คำสั่ง Count, Length, Area, Volume การนับจำนวน วัดความยาว หาพื้นที่ และคำนวณปริมาตร เหล่านี้จะช่วยถอดปริมาณบนแปลนหรือวัตถุได้อย่างอิสระ ถูกต้องและตรวจทานได้</div>
                                </p>
                                <p>
                                    <div><strong>Associate each measurement with one or more BOQ items</strong></div>
                                    <div>ปริมาณแต่ละหมวดสามารถนำไปใช้ได้ เช่น ปริมาณที่วัดจาก Drawing โดยตรงหรือ ปริมาณที่ถอดใส่บน BOQ หากมีพื้นที่หรือวัตถุที่คล้ายกันนำ ไป Copy Paste ได้ทันที</div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-f3f3f3">
                        <div class="container clearfix padding-block">
                            <div class="row">
                                <div class="col-md-8 bottommargin-sm">
                                    <h2>Cooperate</h2>
                                    <p>
                                        <div><strong>Work in the same project with other users</strong></div>
                                        <div>โปรแกรมสามารถทำงานร่วมกันได้ บน drawing เดียวกัน สามารถเปิด Sheet แล้วถอดปริมาณ เมื่อเสร็จสิ้นแล้วก็สามารปิดหมวดนี้ได้เช่นเดียวกัน</div>
                                    </p>
                                    <p>
                                        <div><strong>BOQ items, parameter etc.,</strong></div>
                                        <div>ปริมาณต่างๆเหล่านี้ สามารถล็อคไว้เพื่อป้องกันการแก้ไขได้ครับ</div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img width="360" height="289" class="full-width slider-item-8 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/item-Cooperate.webp') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <div class="row">
                            <div class="col-md-4 bottommargin-sm">
                                <img width="360" height="225" class="full-width slider-item-9 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/item-Export.webp') }}" />
                            </div>
                            <div class="col-md-8">
                                <h2>Export</h2>
                                <p>
                                    <div><strong>Measurement sheets can be exported</strong></div>
                                    <div>นำเข้าและส่งออกปริมาณได้หลากหลาย เช่น DWG, DXF, DGN, BMP,JPG, PDF และอื่นๆ</div>
                                </p>
                                <p>
                                    <div><strong>Export Measurements and BOQ items</strong></div>
                                    <div>ส่งออกเป็นไฟล์ XLS สามารถไปทำงานต่อกับ Microsoft Excel ได้อย่างสมบูรณ์</div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-f3f3f3">
                        <div class="container clearfix padding-block">
                            <div class="row">
                                <div class="col-md-8 bottommargin-sm">
                                    <h2>Cooperate</h2>
                                    <p>
                                        <div><strong>Create custom measurement types</strong></div>
                                        <div>หากแปลนหรือวัตถุมีความซับซ้อน สามารถสร้างสูตรประมาณราคาโดยใช้คำสั่งที่ตัวโปรแกรมมีให้ เช่นการถอดปริมาณท่อดักส์ การถอดนำหนักของอุปกรณ์เป็นต้น</div>
                                    </p>
                                    <p>
                                        <div><strong>Define Parameters</strong></div>
                                        <div>ตั้งชื่อหรือให้ความหมายกับหมวดปริมาณได้ทั้งหมด</div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img width="360" height="295" class="full-width slider-item-9 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/item-Library.webp') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <h2 class="center">Tutorial</h2>
                        <div class="topmargin-sm videoblock">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/7SOSGvplx4k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="tab-content clearfix" id="extraxion-rebars">
                    <div class="container clearfix padding-block">
                        <h3 class="bottommargin-sm border-bottom-rebars center">ExtrAXION Rebars</h3>
                        <div class="center" >ซอฟต์แวร์ถอดปริมาณเหล็กที่แม่นยำ ลดระยะเวลาและคำนวณโดยตรงจากไฟล์ Drawing สามารถถอดปริมาณเหล็กเสริมได้ทุกประเภท ไม่ว่าไฟล์งานโครงสร้างนั้น ถูกสร้างขึ้นมาด้วยซอฟต์แวร์ใดๆ ตัวโปรแกรมใช้งานง่ายเหมาะสำหรับวิศวกรโยธา โครงสร้าง ผู้ประมาณราคา ผู้รับเหมาที่ต้องการความรวดเร็วและแม่นยำ</div>
                    </div>
                    <div class="bg-f3f3f3">
                        <div class="container clearfix padding-block">
                            <div class="row">
                                <div class="col-md-8 bottommargin-sm">
                                    <h2>Organize</h2>
                                    <p>
                                        <div><strong>Build a flexible folder-like layout</strong></div>
                                        <div>สร้างหมวดการถอดปริมาณ เข้าใจง่าย แบ่งตามชื่อและยังเพิ่ม ลดได้ตลอดเวลา</div>
                                    </p>
                                    <p>
                                        <div><strong>The rebar measurement are organized in a tree-like view</strong></div>
                                        <div>ปริมาณเหล็กที่ถอด จะถูกวางตามองค์ประกอบโครงสร้างเป็นตารางตามลำดับเหล็ก เหล็กเสริม เหล็กเส้น เป็นต้น</div>
                                    </p>
                                    <p>
                                        <div><strong>Easily check for any errors or omissions</strong></div>
                                        <div>ถอดปริมาณได้อย่างแม่นยำ ExtrAION Rabar จะดำเนินการแค่ปริมาณเหล็กและตารางลำดับเหล็กเท่านั้น โดยไม่ยุ่งเกี่ยวกับวัตถุอื่น</div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img width="360" height="380" class="full-width slider-item-6 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/rebars-Organize.webp') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <div class="row">
                            <div class="col-md-4 bottommargin-sm">
                                <img width="360" height="284" class="full-width slider-item-7 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/rebars-Measure.webp') }}" />
                            </div>
                            <div class="col-md-8">
                                <h2>Measure</h2>
                                <p>
                                    <div><strong>Steel bar can be measured in different ways</strong></div>
                                    <div>ถอดปริมาณเหล็กเสริมได้หลากหลายวิธี เช่นการเขียนบนแบบโดยตรง หรือ เลือกจากเส้นที่มีโดยกำหนดความยาวแต่ละฝั่งจากรายการเหล็ก ของงานดังกล่าว</div>
                                </p>
                                <p>
                                    <div><strong>Each steel bar belongs to a structure element and is automatically given a code</strong></div>
                                    <div>เหล็กแต่ละรายการนั้น ผู้ใช้สามารถกำหนดรหัสหรือ Code แล้วลิ้งค์กับรายการ BOQ ได้ทันที นอกจากนี้ยังสามารถแสดงรายละเอียด บ่งบอกความสำคัญของเหล็กในงานดังกล่าว</div>
                                </p>
                                <p>
                                    <div><strong>Optionally set the rebar rotation</strong></div>
                                    <div>รูปเหล็กปริมาณสามารถจัดวาง หมุนตามต้องการได้ เพื่อความเรียบร้อยของ BOQ</div>
                                </p>
                                <p>
                                    <div><strong>Provide the length of a dimension that a rebar is repeatd</strong></div>
                                    <div>คำนวณเหล็กที่จัดวางซ้ำๆได้ เช่นระยะพื้น Slab โปรแกรมจะคำนวณให้ทั้งหมดแบบ อัตโนมัติ</div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-f3f3f3">
                        <div class="container clearfix padding-block">
                            <div class="row">
                                <div class="col-md-8 bottommargin-sm">
                                    <h2>Tables</h2>
                                    <p>
                                        <div><strong>Generate detailed reinforcement tables</strong></div>
                                        <div>สร้างตารางรายละเอียดการเสริมแรงของเหล็กโดยเลือกที่เหล็กเสริมที่ต้องการ</div>
                                    </p>
                                    <p>
                                        <div><strong>Export the tables.</strong></div>
                                        <div>ส่งออกเป็นไฟล์นามสกุล XLS ได้ทันที</div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img width="360" height="289" class="full-width slider-item-8 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/rebars-Tables.webp') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <div class="row">
                            <div class="col-md-4 bottommargin-sm">
                                <img width="360" height="225" class="full-width slider-item-9 lazyload" loading="lazy" data-src="{{ asset('onepages/extraxion/images/rebars-Library.webp') }}" />
                            </div>
                            <div class="col-md-8">
                                <h2>Library</h2>
                                <p>
                                    <div><strong>More than 150 Ready –made reinforcement shapes with default values</strong></div>
                                    <div>โปรแกรมมีรายการเหล็กประเภทและรูปทรงต่างๆให้เลือกใช้ โดยคัดเลือกจากวิศวกรที่มีประสปการณ์</div>
                                </p>
                                <p>
                                    <div><strong>User can add new oe modify existing shapres</strong></div>
                                    <div>ผู้ใช้สามารถเพิ่มหรือปรับแต่งรายการหรือรูปทรงได้อย่างอิสระ</div>
                                </p>
                                <p>
                                    <div><strong>Metric and Imperial</strong></div>
                                    <div>รองรับหน่วย เมตร เซนติเมตร มิลลิเมตร และ หน่วยนิ้ว</div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix padding-block">
                        <h2 class="center">Tutorial</h2>
                        <div class="topmargin-sm videoblock">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/vp-NgO4bv8Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

