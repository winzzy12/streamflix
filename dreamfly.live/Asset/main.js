function copyLink(url){
  if (!navigator.clipboard) {
    alert("Browser tidak mendukung copy otomatis");
    return;
  }

  navigator.clipboard.writeText(url).then(() => {
    alert("Link video berhasil disalin!");
  }).catch(() => {
    alert("Gagal menyalin link");
  });
}
