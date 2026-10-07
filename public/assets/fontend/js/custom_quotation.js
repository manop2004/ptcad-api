document.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;

  /* ---------- helpers ---------- */
  const q  = (sel, root=document) => root.querySelector(sel);
  const qa = (sel, root=document) => Array.from(root.querySelectorAll(sel));
  const fireChange = el => el && el.dispatchEvent(new Event('change', { bubbles:true }));
  const hasOption  = (sel, v) => !!sel && Array.prototype.some.call(sel.options, o => String(o.value) === String(v));
  const markFilled = el => el?.closest('.fl-group')?.classList.add('filled');
  const hasValue   = el => !!(el && String(el.value || '').trim() !== '');

  /* =======================================================
   * 1) Type picker (บุคคล/บริษัท) + toggle company field
   * =====================================================*/
  (function TypePicker(){
    const picker = q('#quote-type-picker');
    const typeInput = q('#type');
    const formWrap = q('#quote-form-wrap');
    const companyInput = q('#company');

    function companyWrapper(){
      if(!companyInput) return null;
      return companyInput.closest('.col-md-6') || companyInput.closest('.fl-group') || companyInput.parentElement;
    }
    function toggleCompany(typeVal){
      const wrap = companyWrapper(); if(!wrap) return;
      const isPersonal = String(typeVal) === '1';
      if(isPersonal){
        wrap.classList.add('is-hidden');
        companyInput.dataset.prevRequired = companyInput.required ? 'true' : 'false';
        companyInput.required = false; companyInput.disabled = true;
      }else{
        wrap.classList.remove('is-hidden');
        companyInput.disabled = false;
        if(companyInput.dataset.prevRequired === 'true') companyInput.required = true;
      }
    }

    if(picker){
      const cards = qa('.type-card', picker);
      cards.forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const t = btn.dataset.type;
          if(typeInput) typeInput.value = t;
          cards.forEach(b=>b.classList.remove('active'));
          btn.classList.add('active');
          if(formWrap){ formWrap.style.display='block'; formWrap.scrollIntoView({behavior:'smooth', block:'start'}); }
          toggleCompany(t);
        });
      });
    }
    if(typeInput && typeInput.value){
      formWrap && (formWrap.style.display = 'block');
      picker?.querySelector(`.type-card[data-type="${typeInput.value}"]`)?.classList.add('active');
      toggleCompany(typeInput.value);
    }
  })();

  /* =======================================================
   * 2) Floating label (inputs, textareas, selects)
   * =====================================================*/
  (function FloatingLabels(){
    const els = qa('.form-scope .fl-group input, .form-scope .fl-group textarea, .form-scope .fl-group select');
    els.forEach(el=>{
      const wrap = el.closest('.fl-group');
      const toggle = () => wrap && wrap.classList.toggle('filled', hasValue(el));
      toggle(); // on load (support default/autofill)
      el.addEventListener('input',  toggle);
      el.addEventListener('change', toggle);
    });
  })();

  /* =======================================================
   * 3) Init Select2 (once) + match height with inputs
   * =====================================================*/
  (function Select2Init(){
    if ($ && $.fn && $.fn.select2) {
      $('.form-scope .fl-group select').each(function(){
        if (!$(this).data('select2')) $(this).select2({ theme:'bootstrap4', width:'100%' });
      });
      // float label while open / after clear
      $('.form-scope .fl-group select')
        .on('select2:open', function(){ markFilled(this); })
        .on('select2:close select2:select select2:unselect select2:clear change', function(){
          this.closest('.fl-group')?.classList.toggle('filled', hasValue(this));
        });
    }

    function equalizeSelect2Height(){
      const probe = q('.form-scope .fl-group input, .form-scope .fl-group textarea');
      const targetH = probe ? Math.ceil(probe.getBoundingClientRect().height) : 44;
      qa('.form-scope .select2-container .select2-selection--single').forEach(el=>{
        el.style.height = el.style.minHeight = targetH + 'px';
      });
    }
    equalizeSelect2Height();
    window.addEventListener('resize', equalizeSelect2Height);
    document.addEventListener('select2:open',  equalizeSelect2Height, true);
    document.addEventListener('select2:close', equalizeSelect2Height, true);
    setTimeout(equalizeSelect2Height, 0);
  })();

  /* =======================================================
   * 4) Qty +/- & Grand Total
   * =====================================================*/
  (function CartQtyAndSum(){
    const fmt = new Intl.NumberFormat('th-TH', { minimumFractionDigits:2, maximumFractionDigits:2 });

    function getQtyInput(btn){ return btn.closest('.quantity')?.querySelector('.qty'); }
    function parseMeta(input){
      const step = parseFloat(input.getAttribute('step')) || 1;
      const min  = parseFloat(input.getAttribute('min'))  || 1;
      const max  = input.getAttribute('max') ? parseFloat(input.getAttribute('max')) : Infinity;
      let val = parseFloat((input.value||'').toString().replace(/[^\d.-]/g,'')) || 0;
      return { val, step, min, max };
    }
    function rowUnitPrice(row){
      const el = row.querySelector('.cart-product-price');
      const n  = el ? parseFloat(el.getAttribute('data-unit-price')) : 0;
      return isNaN(n) ? 0 : n;
    }
    function rowQty(row){
      const input = row.querySelector('.qty');
      const v = parseInt((input && input.value) ? input.value.replace(/[^\d]/g,'') : '1', 10);
      return isNaN(v) || v < 1 ? 1 : v;
    }
    function updateGrand(){
      let sum = 0;
      qa('.cart-row').forEach(row => sum += rowUnitPrice(row) * rowQty(row));
      const g = q('#grand-total'); if(g) g.textContent = fmt.format(sum);
    }

    document.addEventListener('click', function(e){
      const t = e.target;
      if(!(t.classList && (t.classList.contains('plus') || t.classList.contains('minus')))) return;
      e.preventDefault();
      const input = getQtyInput(t); if(!input) return;
      const meta = parseMeta(input);
      let next = t.classList.contains('plus') ? meta.val + meta.step : meta.val - meta.step;
      if(next < meta.min) next = meta.min;
      if(next > meta.max) next = meta.max;
      input.value = String(Math.round(next));
      fireChange(input);
      updateGrand();
    });
    document.addEventListener('input',  e => { if(e.target.classList?.contains('qty')){ e.target.value = e.target.value.replace(/[^\d]/g,''); }});
    document.addEventListener('change', e => { if(e.target.classList?.contains('qty')){ let v=parseInt(e.target.value||'0',10); if(isNaN(v)||v<1)v=1; e.target.value=String(v); updateGrand(); }});
    updateGrand();
  })();

  /* =======================================================
   * 5) Address cascade – keep defaults & float labels
   *    province -> amphures -> district (async safe)
   * =====================================================*/
  (async function AddressCascade(){
    const S = {
      province: q('#province'),
      amphures: q('#amphures'),
      district: q('#district'),
      hidProv:  q('#address_province'),
      hidAmph:  q('#address_amphures'),
      hidDist:  q('#address_district'),
    };
    const def = {
      prov: (S.hidProv?.value  || '').trim(),
      amph: (S.hidAmph?.value  || '').trim(),
      dist: (S.hidDist?.value  || '').trim(),
    };

    // ใช้ค่า default เฉพาะตอน select ยังว่างเท่านั้น (ไม่ทับ old())
    if(S.province && !hasValue(S.province) && def.prov && hasOption(S.province, def.prov)){
      S.province.value = def.prov;
      if ($ && $.fn?.select2 && $(S.province).data('select2')) $(S.province).val(def.prov).trigger('change.select2');
      markFilled(S.province); fireChange(S.province); // ให้โหลด amphures
    }

    // รอ amphures ถูกเติม แล้วตั้งค่า
    await new Promise(resolve=>{
      if(!S.amphures || !def.amph){ resolve(); return; }
      if(hasOption(S.amphures, def.amph)){ resolve(); return; }
      const obs = new MutationObserver(()=>{ if(hasOption(S.amphures, def.amph)){ obs.disconnect(); resolve(); } });
      obs.observe(S.amphures, { childList:true, subtree:true });
      setTimeout(()=>{ obs.disconnect(); resolve(); }, 8000);
    });
    if(S.amphures && !hasValue(S.amphures) && def.amph){
      S.amphures.value = def.amph;
      if ($ && $.fn?.select2 && $(S.amphures).data('select2')) $(S.amphures).val(def.amph).trigger('change.select2');
      markFilled(S.amphures); fireChange(S.amphures); // ไปโหลด district
    }

    // รอ district แล้วตั้งค่า
    await new Promise(resolve=>{
      if(!S.district || !def.dist){ resolve(); return; }
      if(hasOption(S.district, def.dist)){ resolve(); return; }
      const obs = new MutationObserver(()=>{ if(hasOption(S.district, def.dist)){ obs.disconnect(); resolve(); } });
      obs.observe(S.district, { childList:true, subtree:true });
      setTimeout(()=>{ obs.disconnect(); resolve(); }, 8000);
    });
    if(S.district && !hasValue(S.district) && def.dist){
      S.district.value = def.dist;
      if ($ && $.fn?.select2 && $(S.district).data('select2')) $(S.district).val(def.dist).trigger('change.select2');
      markFilled(S.district); fireChange(S.district); // ให้ flow คำนวณ zipcode ต่อได้
    }
  })();

});

(function(){
  const form  = document.getElementById('form-quotation');
  const btn   = document.querySelector('#form-quotation .loadding');
  const mask  = document.getElementById('submit-overlay');
  let locked  = false;

  function showOverlay(active){
	  if (!mask) return;
	  // active = true => โชว์ | active = false => ซ่อน
	  mask.hidden = !active;
	}


  function lockFormUI(){
    if (locked) return;
    locked = true;

    // 1) ปุ่มโหลด + disable แค่ปุ่ม
    if (btn){
      btn.classList.add('is-loading');
      btn.setAttribute('disabled', 'disabled');
    }

    // 2) บล็อกการคลิกทั้งฟอร์ม (แต่ "ไม่" disabled ฟิลด์)
    const scope = form.closest('.form-scope');
    if (scope) scope.classList.add('is-busy');

    // 3) โชว์ overlay
    showOverlay(true);

    // 4) กันกดซ้ำ
    form.dataset.submitting = "1";
  }

  function unlockFormUI(){
    locked = false;

    if (btn){
      btn.classList.remove('is-loading');
      btn.removeAttribute('disabled');
    }
    const scope = form.closest('.form-scope');
    if (scope) scope.classList.remove('is-busy');

    showOverlay(false);
    delete form.dataset.submitting;
  }

  // Hook submit ปกติ
  if (form){
    form.addEventListener('submit', function(e){
      if (form.dataset.submitting === "1"){ e.preventDefault(); return false; }
      lockFormUI(); // แล้วปล่อยให้เบราว์เซอร์ submit ตามปกติ
    });
  }

  // reCAPTCHA callback (ถ้ามี)
  window.onSubmit = function(){
    if (!form) return;
    if (form.dataset.submitting === "1") return false;
    lockFormUI();
    form.submit();
  };

  // ==== สถานะตอนโหลดหน้าใหม่ ====
  // 1) ซ่อน overlay เป็นค่าเริ่มต้นทุกครั้ง
  showOverlay(false);

  // 2) ถ้ามี validation error จาก server -> ปลดล็อกทันทีให้กรอกต่อได้
  const hasErrors = !!document.querySelector('.invalid-feedback strong');
  if (hasErrors) unlockFormUI();

  // 3) หน้ามาจาก bfcache (กด back) -> ปลดล็อก
  window.addEventListener('pageshow', function(ev){
    if (ev.persisted) unlockFormUI();
  });

  // กันคลิกซ้ำที่ปุ่ม (บางธีมมี handler ซ้ำ)
  if (btn){
    btn.addEventListener('click', function(e){
      if (form.dataset.submitting === "1"){ e.preventDefault(); return false; }
    });
  }
})();

document.addEventListener('DOMContentLoaded', () => {
  const company = document.getElementById('company');
  if (!company) return;

  // อนุญาตเฉพาะอังกฤษ/ตัวเลข/ช่องว่าง/สัญลักษณ์ที่มักใช้กับชื่อบริษัท
  const allowed = /[^A-Za-z0-9\s\.\,&'’\-\(\)\/]/g;

  // สร้างข้อความ error ใต้ช่องแบบ bootstrap-ish
  const help = document.createElement('small');
  help.className = 'invalid-feedback';
  help.style.display = 'none';
  help.innerHTML = '<strong>กรุณากรอกเป็นภาษาอังกฤษเท่านั้น</strong>';
  company.parentNode.appendChild(help);

  const setInvalid = (msg) => {
    company.classList.add('is-invalid');
    help.style.display = 'block';
    help.innerHTML = `<strong>${msg}</strong>`;
    company.setCustomValidity(msg);
  };

  const clearInvalid = () => {
    company.classList.remove('is-invalid');
    help.style.display = 'none';
    company.setCustomValidity('');
  };

  const sanitize = () => {
    const before = company.value;
    const after = before.replace(allowed, ''); // ตัดอักขระที่ไม่อนุญาตออก
    if (before !== after) {
      company.value = after;
      setInvalid('กรุณากรอกชื่อบริษัทเป็นภาษาอังกฤษเท่านั้น');
    } else if (company.value.trim().length > 0) {
      clearInvalid();
    }
  };

  // กันตอนพิมพ์/วาง
  company.addEventListener('input', sanitize);
  company.addEventListener('paste', () => setTimeout(sanitize, 0));

  // กันตอน submit อีกชั้น (เผื่อโดน bypass)
  const form = document.getElementById('form-quotation');
  if (form) {
    form.addEventListener('submit', (e) => {
      sanitize();
      if (!company.checkValidity()) {
        e.preventDefault();
        company.reportValidity();
        company.focus();
      }
    });
  }
});