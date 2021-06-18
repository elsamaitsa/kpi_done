const dataPersonal = document.getElementById('data-personal')
const dataPerusahaan = document.getElementById('data-perusahaan')
const dataPersonalToggle = document.getElementById('data-personal-toggle')
const dataPerusahaanToggle = document.getElementById('data-perusahaan-toggle')
const tabDivider1 = document.getElementById('tab-divider1')
const tabDivider2 = document.getElementById('tab-divider2')

dataPersonalToggle.addEventListener('click', e=>{
    dataPersonal.style.display="block"
    dataPerusahaan.style.display="none"
    tabDivider1.className="tab-active"
    tabDivider2.className=""
})

dataPerusahaanToggle.addEventListener('click', e=>{
    dataPerusahaan.style.display="block"
    dataPersonal.style.display="none"
    tabDivider1.className=""
    tabDivider2.className="tab-active"
})