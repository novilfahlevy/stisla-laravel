/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.datatable').DataTable();

function swalDelete(callback) {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Data yang sudah dihapus tidak dapat dipulihkan lagi!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Iya'
  }).then(result => callback(result.value));
}