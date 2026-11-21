/* Shared helpers. BACKEND: every Store.get/set call is the single place to swap for fetch() to your API. */
const $=(s,e=document)=>e.querySelector(s),$$=(s,e=document)=>[...e.querySelectorAll(s)];
const esc=s=>String(s??'').replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const asset=p=>!p?'':/^(data:|https?:)/.test(p)?p:'../assets/'+p;
const readFile=f=>new Promise(r=>{const x=new FileReader();x.onload=()=>r(x.result);x.readAsDataURL(f)});
/* downscale an uploaded picture so it fits in localStorage for the demo (a real backend would store the original file) */
const shrink=(file,max=640)=>new Promise(res=>{const r=new FileReader();r.onload=()=>{const im=new Image();im.onload=()=>{const k=Math.min(1,max/Math.max(im.width,im.height)),c=document.createElement('canvas');c.width=Math.round(im.width*k);c.height=Math.round(im.height*k);const x=c.getContext('2d');if(file.type!=='image/png'){x.fillStyle='#fff';x.fillRect(0,0,c.width,c.height)}x.drawImage(im,0,0,c.width,c.height);res(c.toDataURL(file.type==='image/png'?'image/png':'image/jpeg',.85))};im.onerror=()=>res(r.result);im.src=r.result};r.readAsDataURL(file)});
const Store={
  get(k,d){try{const v=localStorage.getItem('inet.'+k);return v?JSON.parse(v):d}catch(e){return d}},
  set(k,v){try{localStorage.setItem('inet.'+k,JSON.stringify(v));return true}catch(e){toast('Browser storage is full, so large images are not kept in this demo');return false}}
};
/* ---- shared content helpers: nested paths, defaults merge, repeaters, page banner ---- */
const gp=(o,p)=>p.split('.').reduce((a,k)=>a==null?a:a[k],o);
const sp=(o,p,v)=>{const k=p.split('.'),l=k.pop();k.reduce((a,x)=>a[x]=a[x]||{},o)[l]=v};
const merge=(d,s)=>{if(s==null)return d;if(Array.isArray(d)||typeof d!=='object'||d===null)return s;const o={...d};for(const k in s)o[k]=k in d?merge(d[k],s[k]):s[k];return o};
/* load(key): saved content laid over the defaults in js/content.js. BACKEND: GET /api/<key> */
const load=k=>merge(JSON.parse(JSON.stringify(DEF[k])),Store.get(k,null));
/* bind every [data-b="a.b"] input to the object O */
function bindB(O,fn){$$('[data-b]').forEach(i=>{i.value=gp(O,i.dataset.b)??'';i.oninput=()=>{sp(O,i.dataset.b,i.value);fn&&fn()}})}
/* repeater: fields = [{k,l,w,a:textarea,o:[options]}] */
function rep(id,A,fields,blank){const el=$('#'+id),f1=(f,it)=>f.o?`<select data-k="${f.k}">${[...new Set([it[f.k],...f.o].filter(x=>x!=null))].map(x=>`<option value="${esc(x)}"${x===it[f.k]?' selected':''}>${esc(x||'None')}</option>`).join('')}</select>`:f.a?`<textarea data-k="${f.k}" rows="2">${esc(it[f.k])}</textarea>`:`<input data-k="${f.k}" value="${esc(it[f.k])}">`,
 dr=()=>{el.innerHTML=A.map((it,i)=>`<div class="rp" data-i="${i}"><div class="rpf">${fields.map(f=>`<label class="${f.w||''}">${f.l}${f1(f,it)}</label>`).join('')}</div><div class="rpb"><button class="ib" data-m="-1" type="button" aria-label="Move up"><i class="fa-solid fa-arrow-up"></i></button><button class="ib" data-m="1" type="button" aria-label="Move down"><i class="fa-solid fa-arrow-down"></i></button><button class="ib d" data-m="x" type="button" aria-label="Remove"><i class="fa-solid fa-trash"></i></button></div></div>`).join('')||'<p class="mut">Nothing here yet.</p>'};
 el.oninput=e=>{const r=e.target.closest('.rp');if(r)A[r.dataset.i][e.target.dataset.k]=e.target.value};
 el.onclick=e=>{const b=e.target.closest('[data-m]');if(!b)return;const i=+b.closest('.rp').dataset.i,m=b.dataset.m;if(m==='x')A.splice(i,1);else{const j=i+ +m;if(j<0||j>=A.length)return;[A[i],A[j]]=[A[j],A[i]]}dr()};
 const ab=$('[data-add="'+id+'"]');if(ab)ab.onclick=()=>{A.push({...blank});dr()};dr()}
/* the heading + intro + button block every inner page starts with ("Our" + "courses", tagline, button) */
const BANNER=(t='Page heading')=>`<div class="panel"><h3>${t}</h3><div class="pb"><div class="g2"><label>Heading, first word<input data-b="hero.a"></label><label>Heading, highlighted word<input data-b="hero.b"></label></div><label>Tagline<input data-b="hero.p"></label><div class="g2"><label>Button text<input data-b="hero.btn"></label><label>Button link<input data-b="hero.href"></label></div></div></div>`;
function toast(m){let t=$('.tg');if(!t){t=document.createElement('div');t.className='tg';t.setAttribute('role','status');document.body.append(t)}
  t.textContent=m;t.classList.add('on');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('on'),2400)}
const NAV=[['index.php','Dashboard','fa-gauge'],['home-content.php','Home page','fa-house'],['about.php','About','fa-circle-info'],['courses.php','Courses','fa-graduation-cap'],['services.php','Services','fa-screwdriver-wrench'],['placements.php','Placements','fa-user-tie'],['gallery.php','Gallery','fa-images'],['certifications.php','Certifications','fa-award'],['contact.php','Contact & footer','fa-phone']];
function openDr(id){$('#'+id).classList.add('open');$('#bd').classList.add('on')}
function closeDr(){$$('.dr.open').forEach(d=>d.classList.remove('open'));$('#side').classList.remove('open');$('#bd').classList.remove('on')}
document.addEventListener('DOMContentLoaded',()=>{
  const pg=document.body.dataset.page;
  $('#side').innerHTML=`<a class="logo" href="index.php"><img src="../assets/logo.png" alt="I-Net Infotech admin"></a><div class="gt">Website content</div>`+
    NAV.map(n=>`<a class="nv${n[0]===pg?' on':''}" href="${n[0]}"><i class="fa-solid ${n[2]}"></i>${n[1]}</a>`).join('');
  $('#top').innerHTML=`<button class="menu" aria-label="Open menu" aria-expanded="false" aria-controls="side"><i class="fa-solid fa-bars"></i></button><h1>${esc(document.body.dataset.title)}</h1><a class="site" href="../index.php" target="_blank" rel="noopener" aria-label="View site"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>View site</span></a><span class="av" title="Signed in as Admin">AD</span>`;
  $('.menu').onclick=()=>{const o=$('#side').classList.toggle('open');$('#bd').classList.toggle('on',o);$('.menu').setAttribute('aria-expanded',o)};
  const bd=document.createElement('div');bd.className='bd';bd.id='bd';bd.onclick=closeDr;document.body.append(bd);
  addEventListener('keydown',e=>{if(e.key==='Escape')closeDr()});
  document.addEventListener('click',e=>{if(e.target.closest('[data-close]'))closeDr()});
});
