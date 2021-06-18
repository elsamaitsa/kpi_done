const keranjang = document.getElementById('toggle-keranjang')
const popupKeranjang = document.getElementById('popup-keranjang')
const notifikasi = document.getElementById('toggle-notifikasi')
const popupNotifikasi = document.getElementById('popup-notifikasi')
const pesan = document.getElementById('toggle-pesan')
const popupPesan = document.getElementById('popup-pesan')
const profile = document.getElementById('toggle-profile')
const popupProfile = document.getElementById('popup-profile')

keranjang.addEventListener('click', () => {
    if (popupKeranjang.style.display === "none") {
        popupKeranjang.style.display = "block";
    } else {
        popupKeranjang.style.display = "none";
    }
})

notifikasi.addEventListener('click', () => {
    if (popupNotifikasi.style.display === "none") {
        popupNotifikasi.style.display = "block";
    } else {
        popupNotifikasi.style.display = "none";
    }
})

pesan.addEventListener('click', () => {
    if (popupPesan.style.display === "none") {
        popupPesan.style.display = "block";
    } else {
        popupPesan.style.display = "none";
    }
})

profile.addEventListener('click', () => {
    if (popupProfile.style.display === "none") {
        popupProfile.style.display = "block";
    } else {
        popupProfile.style.display = "none";
    }
})


