$(function() {
    var u = $(".datatables-users"),
        m = $(".select2"),
        f = baseUrl + "app/user/view/account",
        l = $("#offcanvasAddUser");
    if (m.length) {
        var d = m;
        select2Focus(d), d.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Country",
            dropdownParent: d.parent()
        })
    }
    if ($.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    }), u.length) {
        var p = u.DataTable({
            processing: !0,
            serverSide: !0,
            ajax: {
                url: baseUrl + "user-list"
            },
            columns: [{
                data: ""
            }, {
                data: "id"
            }, {
                data: "name"
            }, {
                data: "email"
            }, {
                data: "email_verified_at"
            }, {
                data: "action"
            }],
            columnDefs: [{
                className: "control",
                searchable: !1,
                orderable: !1,
                responsivePriority: 2,
                targets: 0,
                render: function(e, n, a, o) {
                    return ""
                }
            }, {
                searchable: !1,
                orderable: !1,
                targets: 1,
                render: function(e, n, a, o) {
                    return `<span>${a.fake_id}</span>`
                }
            }, {
                targets: 2,
                responsivePriority: 4,
                render: function(e, n, a, o) {
                    var c = a.name,
                        t = Math.floor(Math.random() * 6),
                        r = ["success", "danger", "warning", "info", "dark", "primary", "secondary"],
                        s = r[t],
                        c = a.name,
                        i = c.match(/\b\w/g) || [],
                        v;
                    i = ((i.shift() || "") + (i.pop() || "")).toUpperCase(), v = '<span class="avatar-initial rounded-circle bg-label-' + s + '">' + i + "</span>";
                    var g = '<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar avatar-sm me-3">' + v + '</div></div><div class="d-flex flex-column"><a href="' + f + '" class="text-body text-truncate"><span class="fw-medium">' + c + "</span></a></div></div>";
                    return g
                }
            }, {
                targets: 3,
                render: function(e, n, a, o) {
                    var t = a.email;
                    return '<span class="user-email">' + t + "</span>"
                }
            }, {
                targets: 4,
                className: "text-center",
                render: function(e, n, a, o) {
                    var t = a.email_verified_at;
                    return `${t?'<i class="mdi mdi-shield-check-outline mdi-20px text-success"></i>':'<i class="mdi mdi-shield-off-outline mdi-20px text-danger" ></i>'}`
                }
            }, {
                targets: -1,
                title: "Actions",
                searchable: !1,
                orderable: !1,
                render: function(e, n, a, o) {
                    return `<div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon edit-record" data-id="${a.id}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="mdi mdi-pencil-outline mdi-20px"></i></button><button class="btn btn-sm btn-icon delete-record" data-id="${a.id}"><i class="mdi mdi-delete-outline mdi-20px"></i></button><button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical mdi-20px"></i></button><div class="dropdown-menu dropdown-menu-end m-0"><a href="` + f + '" class="dropdown-item">View</a><a href="javascript:;" class="dropdown-item">Suspend</a></div></div>'
                }
            }],
            order: [
                [2, "desc"]
            ],
            dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Search.."
            },
            buttons: [{
                extend: "collection",
                className: "btn btn-label-primary dropdown-toggle mx-3 waves-effect waves-light",
                text: '<i class="mdi mdi-export-variant me-sm-1"></i>Export',
                buttons: [{
                    extend: "print",
                    title: "Users",
                    text: '<i class="mdi mdi-printer-outline me-1" ></i>Print',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [2, 3],
                        format: {
                            body: function(e, n, a) {
                                if (e.length <= 0) return e;
                                var o = $.parseHTML(e),
                                    t = "";
                                return $.each(o, function(r, s) {
                                    s.classList !== void 0 && s.classList.contains("user-name") ? t = t + s.lastChild.textContent : t = t + s.innerText
                                }), t
                            }
                        }
                    },
                    customize: function(e) {
                        $(e.document.body).css("color", config.colors.headingColor).css("border-color", config.colors.borderColor).css("background-color", config.colors.body), $(e.document.body).find("table").addClass("compact").css("color", "inherit").css("border-color", "inherit").css("background-color", "inherit")
                    }
                }, {
                    extend: "csv",
                    title: "Users",
                    text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [2, 3],
                        format: {
                            body: function(e, n, a) {
                                if (e.length <= 0) return e;
                                var o = $.parseHTML(e),
                                    t = "";
                                return $.each(o, function(r, s) {
                                    s.classList.contains("user-name") ? t = t + s.lastChild.textContent : t = t + s.innerText
                                }), t
                            }
                        }
                    }
                }, {
                    extend: "excel",
                    title: "Users",
                    text: '<i class="mdi mdi-file-excel-outline me-1" ></i>Excel',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [2, 3],
                        format: {
                            body: function(e, n, a) {
                                if (e.length <= 0) return e;
                                var o = $.parseHTML(e),
                                    t = "";
                                return $.each(o, function(r, s) {
                                    s.classList.contains("user-name") ? t = t + s.lastChild.textContent : t = t + s.innerText
                                }), t
                            }
                        }
                    }
                }, {
                    extend: "pdf",
                    title: "Users",
                    text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [2, 3],
                        format: {
                            body: function(e, n, a) {
                                if (e.length <= 0) return e;
                                var o = $.parseHTML(e),
                                    t = "";
                                return $.each(o, function(r, s) {
                                    s.classList.contains("user-name") ? t = t + s.lastChild.textContent : t = t + s.innerText
                                }), t
                            }
                        }
                    }
                }, {
                    extend: "copy",
                    title: "Users",
                    text: '<i class="mdi mdi-content-copy me-1" ></i>Copy',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [2, 3],
                        format: {
                            body: function(e, n, a) {
                                if (e.length <= 0) return e;
                                var o = $.parseHTML(e),
                                    t = "";
                                return $.each(o, function(r, s) {
                                    s.classList.contains("user-name") ? t = t + s.lastChild.textContent : t = t + s.innerText
                                }), t
                            }
                        }
                    }
                }]
            }, {
                text: '<i class="mdi mdi-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                className: "add-new btn btn-primary waves-effect waves-light",
                attr: {
                    "data-bs-toggle": "offcanvas",
                    "data-bs-target": "#offcanvasAddUser"
                }
            }],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(e) {
                            var n = e.data();
                            return "Details of " + n.name
                        }
                    }),
                    type: "column",
                    renderer: function(e, n, a) {
                        var o = $.map(a, function(t, r) {
                            return t.title !== "" ? '<tr data-dt-row="' + t.rowIndex + '" data-dt-column="' + t.columnIndex + '"><td>' + t.title + ":</td> <td>" + t.data + "</td></tr>" : ""
                        }).join("");
                        return o ? $('<table class="table"/><tbody />').append(o) : !1
                    }
                }
            }
        });
        $(".dt-buttons > .btn-group > button").removeClass("btn-secondary")
    }
    $(document).on("click", ".delete-record", function() {
        var e = $(this).data("id"),
            n = $(".dtr-bs-modal.show");
        n.length && n.modal("hide"), Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: "btn btn-primary me-3",
                cancelButton: "btn btn-label-secondary"
            },
            buttonsStyling: !1
        }).then(function(a) {
            a.value ? ($.ajax({
                type: "DELETE",
                url: `${baseUrl}user-list/${e}`,
                success: function() {
                    p.draw()
                },
                error: function(o) {
                    console.log(o)
                }
            }), Swal.fire({
                icon: "success",
                title: "Deleted!",
                text: "The user has been deleted!",
                customClass: {
                    confirmButton: "btn btn-success"
                }
            })) : a.dismiss === Swal.DismissReason.cancel && Swal.fire({
                title: "Cancelled",
                text: "The User is not deleted!",
                icon: "error",
                customClass: {
                    confirmButton: "btn btn-success"
                }
            })
        })
    }), $(document).on("click", ".edit-record", function() {
        var e = $(this).data("id"),
            n = $(".dtr-bs-modal.show");
        n.length && n.modal("hide"), $("#offcanvasAddUserLabel").html("Edit User"), $.get(`${baseUrl}user-list/${e}/edit`, function(a) {
            $("#user_id").val(a.id), $("#add-user-fullname").val(a.name), $("#add-user-email").val(a.email)
        })
    }), $(".add-new").on("click", function() {
        $("#user_id").val(""), $("#offcanvasAddUserLabel").html("Add User")
    });
    const x = document.getElementById("addNewUserForm"),
        h = FormValidation.formValidation(x, {
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Please enter fullname"
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your email"
                        },
                        emailAddress: {
                            message: "The value is not a valid email address"
                        }
                    }
                },
                userContact: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your contact"
                        }
                    }
                },
                company: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your company"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: function(e, n) {
                        return ".mb-4"
                    }
                }),
                submitButton: new FormValidation.plugins.SubmitButton,
                autoFocus: new FormValidation.plugins.AutoFocus
            }
        }).on("core.form.valid", function() {
            $.ajax({
                data: $("#addNewUserForm").serialize(),
                url: `${baseUrl}user-list`,
                type: "POST",
                success: function(e) {
                    p.draw(), l.offcanvas("hide"), Swal.fire({
                        icon: "success",
                        title: `Successfully ${e}!`,
                        text: `User ${e} Successfully.`,
                        customClass: {
                            confirmButton: "btn btn-success"
                        }
                    })
                },
                error: function(e) {
                    l.offcanvas("hide"), Swal.fire({
                        title: "Duplicate Entry!",
                        text: "Your email should be unique.",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-success"
                        }
                    })
                }
            })
        });
    l.on("hidden.bs.offcanvas", function() {
        h.resetForm(!0)
    });
    const b = document.querySelectorAll(".phone-mask");
    b && b.forEach(function(e) {
        new Cleave(e, {
            phone: !0,
            phoneRegionCode: "US"
        })
    })
});
