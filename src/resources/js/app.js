const wrapDropdownMenu = document.querySelector(".wrap__dropdown_menu");
const btnToggleSidebar = document.querySelector(".btn__toggle_sidebar");
const htmlExpanded     = document.documentElement;

btn__dropdown_toggle.addEventListener("click", (e) => {
    wrapDropdownMenu.classList.toggle("show");
});

btnToggleSidebar.addEventListener("click", e => {
    htmlExpanded.classList.toggle("layout__expanded");
});

document.addEventListener('click', e => {
    if(htmlExpanded.classList.contains("layout__expanded")) {
        console.log('click');
        if (!left_sidebar.contains(e.target) && !btnToggleSidebar.contains(e.target)) {
            htmlExpanded.classList.remove("layout__expanded")
        };
    };
});

document.addEventListener('click', e => {
    if(wrapDropdownMenu.classList.contains("show")) {
        if (!content_dropdown_menu.contains(e.target) && !btn__dropdown_toggle.contains(e.target)) {
            wrapDropdownMenu.classList.remove("show")
        };
    }
});

(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
  
        form.classList.add('was-validated')
      }, false)
    })

    const formCreate = document.querySelectorAll(".form-create");
    Array.from(formCreate).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");

                if (form.checkValidity()) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menyimpan data ini!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            },
            false
        );
    });

    const formsEdit = document.querySelectorAll(".form-edit");
    Array.from(formsEdit).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");

                if (form.checkValidity()) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menyimpan data ini!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            },
            false
        );
    });

    const formsDelete = document.querySelectorAll('.form-destroy');
    Array.from(formsDelete).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");

                if (form.checkValidity()) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Are you sure delete this?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ff3e1d",
                        cancelButtonColor: "#8592a3",
                        confirmButtonText: "Yes! Delete it",
                        focusCancel: true,
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Successfully",
                                text: "Your file has been deleted ✅",
                                icon: "success",
                                timer: 800,
                                didOpen: () => {
                                    Swal.showLoading()
                                  },
                                  willClose: () => {
                                    form.submit();
                                  }
                            });
                        }
                    });
                }
            }, false
        );
    });

    const formSubmitQuotation = document.querySelectorAll('.form-submit-quotation');
    Array.from(formSubmitQuotation).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");

                if (form.checkValidity()) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Are you sure submit this quotation?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#696cff",
                        cancelButtonColor: "#8592a3",
                        confirmButtonText: "Yes!Submit",
                        focusCancel: true,
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Successfully",
                                text: "Quotation has been added ✅",
                                icon: "success",
                                timer: 800,
                                didOpen: () => {
                                    Swal.showLoading()
                                  },
                                  willClose: () => {
                                    form.submit();
                                  }
                            });
                        }
                    });
                }
            }, false
        );
    });

    const submitItemQuotation = document.querySelectorAll('.form-submit-item-quo');
    Array.from(submitItemQuotation).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");

                if (form.checkValidity()) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Anda Yakin 🤔?",
                        text: "Data tidak dapat diedit kembali",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#696cff",
                        cancelButtonColor: "#8592a3",
                        confirmButtonText: "Ya!",
                        focusCancel: true,
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Berhasil",
                                text: "Penawaran berhasil di submit 🚀",
                                icon: "success",
                                timer: 800,
                                didOpen: () => {
                                    Swal.showLoading()
                                  },
                                  willClose: () => {
                                    form.submit();
                                  }
                            });
                        }
                    });
                }
            }, false
        );
    });

})()