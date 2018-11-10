# media-sizer

Adalah module yang memungkinkan file gambar diresize ketika diminta oleh client.
berdasarkan request url.

Sebagai contoh, untuk media file `aa/bb/cc/dd/aabbccdd.png` akan dilayani melalui
url `http://site.com/media/aa/bb/cc/dd/aabbccdd.png`. Untuk mendapatkan versi webp
file tersebut, bisa dengan mengakses `http://site.com/media/aa/bb/cc/dd/aabbccdd.png.webp`.

Untuk mendapatkan file dengan ukuran 100 ( lebar ) x 150 ( tinggi ), bisa mengakses
`http://site.com/media/aa/bb/cc/dd/aabbccdd_100x150.png`. Dan untuk versi `webp` dari
`http://site.com/media/aa/bb/cc/dd/aabbccdd_100x150.png.webp`

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install media-sizer
```