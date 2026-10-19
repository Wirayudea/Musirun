<style>
.admin-confirm-modal{position:fixed;z-index:2000;inset:0;display:grid;place-items:center;padding:20px;visibility:hidden;opacity:0;transition:opacity .2s ease,visibility .2s ease}.admin-confirm-modal.is-open{visibility:visible;opacity:1}.admin-confirm-modal__backdrop{position:absolute;inset:0;background:rgba(3,9,16,.78);backdrop-filter:blur(7px)}.admin-confirm-modal__card{position:relative;width:min(470px,100%);padding:30px;border:1px solid rgba(0,178,255,.4);border-radius:12px;background:linear-gradient(145deg,#0b1726,#101522);box-shadow:0 24px 70px rgba(0,0,0,.5);transform:translateY(14px) scale(.98);transition:transform .2s ease}.admin-confirm-modal.is-open .admin-confirm-modal__card{transform:translateY(0) scale(1)}.admin-confirm-modal__card:before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:12px 12px 0 0;background:linear-gradient(90deg,#f5be00,#00B2FF)}.admin-confirm-modal__close{position:absolute;top:12px;right:14px;width:32px;height:32px;border:1px solid rgba(168,184,200,.35);border-radius:50%;color:#a8b8c8;background:transparent;font-size:1.35rem;line-height:1;cursor:pointer}.admin-confirm-modal__close:hover{color:#07101c;background:#f5be00}.admin-confirm-modal__eyebrow{margin:0 0 8px;color:#f5be00;font-size:.76rem;font-weight:700;letter-spacing:.14em}.admin-confirm-modal h2{margin:0;color:#fff;font-size:1.35rem}.admin-confirm-modal p{margin:12px 0 0;color:#a8b8c8;line-height:1.45}.admin-confirm-modal__reason{display:none;margin-top:18px}.admin-confirm-modal__reason.is-visible{display:block}.admin-confirm-modal__reason label{display:block;margin-bottom:7px;color:#fff;font-weight:700}.admin-confirm-modal__reason textarea{width:100%;min-height:110px;padding:10px;border:1px solid rgba(168,184,200,.45);border-radius:6px;color:#fff;background:#07101c;font:inherit;resize:vertical}.admin-confirm-modal__reason textarea:focus{outline:2px solid #00b2ff;outline-offset:2px}.admin-confirm-modal__reason-error{display:none;margin-top:6px;color:#ff8b67}.admin-confirm-modal__reason-error.is-visible{display:block}.admin-confirm-modal__actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px}.admin-confirm-modal__actions button{min-height:40px;padding:9px 16px;border-radius:6px;font-weight:700;cursor:pointer}.admin-confirm-modal__cancel{border:1px solid rgba(168,184,200,.4);color:#dce8f2;background:transparent}.admin-confirm-modal__confirm{border:0;color:#07101c;background:linear-gradient(90deg,#f5be00,#ffd95a)}.admin-confirm-modal__cancel:hover{border-color:#00b2ff;color:#fff}.admin-confirm-modal__confirm:hover{background:linear-gradient(90deg,#00b2ff,#7cdbff)}body.admin-confirm-open{overflow:hidden}
</style>
<div class="admin-confirm-modal" id="adminConfirmModal" aria-hidden="true">
    <div class="admin-confirm-modal__backdrop" data-admin-confirm-close></div>
    <section class="admin-confirm-modal__card" role="dialog" aria-modal="true" aria-labelledby="adminConfirmTitle">
        <button class="admin-confirm-modal__close" type="button" aria-label="Tutup" data-admin-confirm-close>&times;</button>
        <p class="admin-confirm-modal__eyebrow">KONFIRMASI ADMIN</p>
        <h2 id="adminConfirmTitle">Simpan perubahan ini?</h2>
        <p>Pastikan data yang dipilih sudah benar. Perubahan akan langsung diterapkan pada data peserta.</p>
        <div class="admin-confirm-modal__reason" id="adminRejectionReason">
            <label for="adminRejectionReasonInput">Alasan penolakan <span aria-hidden="true">*</span></label>
            <textarea id="adminRejectionReasonInput" maxlength="1000" placeholder="Jelaskan alasan pendaftaran belum dapat disetujui." aria-describedby="adminRejectionReasonError"></textarea>
            <small class="admin-confirm-modal__reason-error" id="adminRejectionReasonError">Alasan penolakan wajib diisi.</small>
        </div>
        <div class="admin-confirm-modal__actions"><button class="admin-confirm-modal__cancel" type="button" data-admin-confirm-close>Periksa Lagi</button><button class="admin-confirm-modal__confirm" type="button" id="adminConfirmSubmit">Ya, Simpan</button></div>
    </section>
</div>
<script>
(function(){
    const modal=document.getElementById('adminConfirmModal');
    if(!modal)return;

    let pendingForm=null;
    const reasonContainer=document.getElementById('adminRejectionReason');
    const reasonInput=document.getElementById('adminRejectionReasonInput');
    const reasonError=document.getElementById('adminRejectionReasonError');
    const confirmButton=document.getElementById('adminConfirmSubmit');

    const closeModal=()=>{
        pendingForm=null;
        reasonInput.value='';
        reasonError.classList.remove('is-visible');
        reasonContainer.classList.remove('is-visible');
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden','true');
        document.body.classList.remove('admin-confirm-open');
    };

    document.querySelectorAll('form').forEach(form=>{
        const methodInput=form.querySelector('input[name="_method"]');
        if(!methodInput||!['PATCH','PUT'].includes(methodInput.value.toUpperCase()))return;

        form.addEventListener('submit',event=>{
            if(form.dataset.confirmed==='true'){
                delete form.dataset.confirmed;
                return;
            }

            event.preventDefault();
            pendingForm=form;
            const isRejection=form.querySelector('input[name="status"]')?.value==='rejected';
            reasonContainer.classList.toggle('is-visible',isRejection);
            reasonInput.value='';
            reasonError.classList.remove('is-visible');
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden','false');
            document.body.classList.add('admin-confirm-open');

            if(isRejection)reasonInput.focus();
            else confirmButton.focus();
        });
    });

    document.querySelectorAll('[data-admin-confirm-close]').forEach(button=>button.addEventListener('click',closeModal));
    confirmButton.addEventListener('click',()=>{
        if(!pendingForm)return;

        const form=pendingForm;
        const isRejection=form.querySelector('input[name="status"]')?.value==='rejected';
        if(isRejection&&!reasonInput.value.trim()){
            reasonError.classList.add('is-visible');
            reasonInput.focus();
            return;
        }

        form.querySelector('input[name="rejection_reason"]')?.remove();
        if(isRejection){
            const reasonField=document.createElement('input');
            reasonField.type='hidden';
            reasonField.name='rejection_reason';
            reasonField.value=reasonInput.value.trim();
            form.appendChild(reasonField);
        }

        form.dataset.confirmed='true';
        closeModal();
        form.requestSubmit();
    });

    reasonInput.addEventListener('input',()=>{
        if(reasonInput.value.trim())reasonError.classList.remove('is-visible');
    });
    document.addEventListener('keydown',event=>{
        if(event.key==='Escape')closeModal();
    });
})();
</script>
