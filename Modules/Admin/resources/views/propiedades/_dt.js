$(function() {
    var m = $(".datatables-ajax"),
        f = $(".dt-column-search"),
        s = $(".dt-advanced-search"),
        p = $(".dt-responsive"),
        b = $(".start_date"),
        h = $(".end_date"),
        c = $(".flatpickr-range"),
        v = "MM/DD/YYYY";
    c.length && c.flatpickr({
        mode: "range",
        dateFormat: "m/d/Y",
        orientation: isRtl ? "auto right" : "auto left",
        locale: {
            format: v
        },
        onClose: function(t, e, l) {
            var n = "",
                a = new Date;
            t[0] != null && (n = moment(t[0]).format("MM/DD/YYYY"), b.val(n)), t[1] != null && (a = moment(t[1]).format("MM/DD/YYYY"), h.val(a)), $(c).trigger("change").trigger("keyup")
        }
    });

    function y(t, e) {
        if (t == 5) {
            var l = b.val(),
                n = h.val();
            l !== "" && n !== "" && ($.fn.dataTableExt.afnFiltering.length = 0, s.dataTable().fnDraw(), j(t, l, n)), s.dataTable().fnDraw()
        } else s.DataTable().column(t).search(e, !1, !0).draw()
    }
    $.fn.dataTableExt.afnFiltering.length = 0;
    var j = function(t, e, l) {
            $.fn.dataTableExt.afnFiltering.push(function(n, a, r) {
                var d = u(a[t]),
                    o = u(e),
                    i = u(l);
                return o <= d && d <= i || d >= o && i === "" && o !== "" ? !0 : d <= i && o === "" && i !== ""
            })
        },
        u = function(t) {
            var e = new Date(t),
                l = e.getFullYear() + "" + ("0" + (e.getMonth() + 1)).slice(-2) + ("0" + e.getDate()).slice(-2);
            return l
        };
    if (m.length && m.dataTable({
        processing: !0,
        ajax: assetsPath + "json/ajax.php",
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    }), f.length) {
        $(".dt-column-search thead tr").clone(!0).appendTo(".dt-column-search thead"), $(".dt-column-search thead tr:eq(1) th").each(function(t) {
            var e = $(this).text(),
                l = $('<input type="text" class="form-control" placeholder="Search ' + e + '" />');
            $(this).css("border-left", "none"), t === $(".dt-column-search thead tr:eq(1) th").length - 1 && $(this).css("border-right", "none"), $(this).html(l), $("input", this).on("keyup change", function() {
                g.column(t).search() !== this.value && g.column(t).search(this.value).draw()
            })
        });
        var g = f.DataTable({
            ajax: assetsPath + "json/table-datatable.json",
            columns: [{
                data: "full_name"
            }, {
                data: "email"
            }, {
                data: "post"
            }, {
                data: "city"
            }, {
                data: "start_date"
            }, {
                data: "salary"
            }],
            orderCellsTop: !0,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        })
    }
    s.length && s.DataTable({
        dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>",
        ajax: assetsPath + "json/table-datatable.json",
        columns: [{
            data: ""
        }, {
            data: "full_name"
        }, {
            data: "email"
        }, {
            data: "post"
        }, {
            data: "city"
        }, {
            data: "start_date"
        }, {
            data: "salary"
        }],
        columnDefs: [{
            className: "control",
            orderable: !1,
            targets: 0,
            render: function(t, e, l, n) {
                return ""
            }
        }],
        orderCellsTop: !0,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(t) {
                        var e = t.data();
                        return "Details of " + e.full_name
                    }
                }),
                type: "column",
                renderer: function(t, e, l) {
                    var n = $.map(l, function(a, r) {
                        return a.title !== "" ? '<tr data-dt-row="' + a.rowIndex + '" data-dt-column="' + a.columnIndex + '"><td>' + a.title + ":</td> <td>" + a.data + "</td></tr>" : ""
                    }).join("");
                    return n ? $('<table class="table"/><tbody />').append(n) : !1
                }
            }
        }
    }), $("input.dt-input").on("keyup", function() {
        y($(this).attr("data-column"), $(this).val())
    }), p.length && p.DataTable({
        ajax: assetsPath + "json/table-datatable.json",
        columns: [{
            data: ""
        }, {
            data: "full_name"
        }, {
            data: "email"
        }, {
            data: "post"
        }, {
            data: "city"
        }, {
            data: "start_date"
        }, {
            data: "salary"
        }, {
            data: "age"
        }, {
            data: "experience"
        }, {
            data: "status"
        }],
        columnDefs: [{
            className: "control",
            orderable: !1,
            targets: 0,
            searchable: !1,
            render: function(t, e, l, n) {
                return ""
            }
        }, {
            targets: -1,
            render: function(t, e, l, n) {
                var a = l.status,
                    r = {
                        1: {
                            title: "Current",
                            class: "bg-label-primary"
                        },
                        2: {
                            title: "Professional",
                            class: " bg-label-success"
                        },
                        3: {
                            title: "Rejected",
                            class: " bg-label-danger"
                        },
                        4: {
                            title: "Resigned",
                            class: " bg-label-warning"
                        },
                        5: {
                            title: "Applied",
                            class: " bg-label-info"
                        }
                    };
                return typeof r[a] > "u" ? t : '<span class="badge rounded-pill ' + r[a].class + '">' + r[a].title + "</span>"
            }
        }],
        destroy: !0,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(t) {
                        var e = t.data();
                        return "Details of " + e.full_name
                    }
                }),
                type: "column",
                renderer: function(t, e, l) {
                    var n = $.map(l, function(a, r) {
                        return a.title !== "" ? '<tr data-dt-row="' + a.rowIndex + '" data-dt-column="' + a.columnIndex + '"><td>' + a.title + ":</td> <td>" + a.data + "</td></tr>" : ""
                    }).join("");
                    return n ? $('<table class="table"/><tbody />').append(n) : !1
                }
            }
        }
    }), setTimeout(() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(".dataTables_length .form-select").removeClass("form-select-sm")
    }, 300)
});
