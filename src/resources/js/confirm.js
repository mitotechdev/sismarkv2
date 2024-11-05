function showAlert(title, message, icon) {
    Swal.fire({
        title: title,
        html: message,
        icon: icon,
        confirmButtonText: 'OK'
    });
}

function confirmEdit(url) {

    const form = document.getElementById(url);
    if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
        form.classList.add('was-validated')
    } else {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menyimpan perubahan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
}

function confirmUpdateProgress(url) {
    const form = document.getElementById(url);
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: 'Kegiatan ini akan ditandai telah selesai!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function confirmDeleteActivity(url) {
    const form = document.getElementById(url);
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: 'Anda akan menghapus data ini!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function confirmDelete(name, tableName = "Master Data", url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan menghapus <b>' + name + '</b> dari ' + tableName + '!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}

function commonDelete(url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan menghapus data ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}

function confirmRecovery(name, url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan mengembalikan data <b>' + name + '</b> ke database!',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}

function logOut(url) {
    const form = document.getElementById(url);
    Swal.fire({
        title: 'Log Out?',
        html: 'Anda yakin ingin keluar dari program ini!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}


function confirmDeletePermanently(name, url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan menghapus permanen <b>' + name + '</b> dari database!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}

function confirmDeleteItemSalesOrders(url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan menghapus item ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}


//function for Sales Order Item Edit
function itemValueChange(data) {
    const qtyChange = document.getElementById('qty_'+data).value || 0;
    const priceChange = document.getElementById('price_'+data).value || 0;
    const discountChange = document.getElementById('discount_'+data).value || 0;
    const grandTotalUpdate = document.getElementById('show_grand_total_'+data);
    const totalAmountUpdate = document.getElementById('total_amount_'+data);
    const totalPrice = qtyChange * (priceChange - discountChange);

    grandTotalUpdate.value = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(totalPrice);

    totalAmountUpdate.value = totalPrice;
}

function submitItemSalesOrder(url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Pastikan data telah benar, anda tidak dapat mengedit data ini kembali!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}


function confirmApprove(url) {
    const form = document.getElementById(url);
    Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda yakin ingin menyetujui PO ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
}

