!(function () {
    var e = ["section", "column", "widget", "container"],
        n = [];
    elementor.on("preview:loaded", function () {
        e.forEach(function (t, o) {
            elementor.hooks.addFilter("elements/" + e[o] + "/contextMenuGroups", function (t, a) {
                return (
                    n.push(a),
                    t.push({
                        name: "translentor_" + e[o],
                        actions: [
                            {   
                                name: "swt_image_converter",
                                title: "Download As Image",
                                icon: "eicon-image",
                                callback: function () {
                                    elementor.selection.getElements(a.getContainer()).forEach(function (e) {
                                        if(a.model.get('elType')==='section')
                                        {
                                        html2canvas(e.args.view.el, { allowTaint: !0, useCORS: !0 }).then(function (e) {
                                            var n = document.createElement("a");
                                            document.body.appendChild(n),
                                                (n.download = Math.floor(Date.now() / 1e3) + "-" + a.model.get("elType") + "-" + a.model.get("id") + ".png"),
                                                (n.href = e.toDataURL()),
                                                (n.target = "_blank"),
                                                n.click();
                                        });
                                    }else{
                                        html2canvas(e.args.view.el, { allowTaint: !0, useCORS: !0 }).then(function (e) {
                                            var n = document.createElement("a");
                                            document.body.appendChild(n),
                                                (n.download = Math.floor(Date.now() / 1e3) + "-" + a.model.get("elType") + "-" + a.model.get("id") + ".png"),
                                                (n.href = e.toDataURL()),
                                                (n.target = "_blank"),
                                                n.click();
                                        });
                                    }
                                    });
                                },
                            },
                            {
                                name: "swt_fullpageimage_converter",
                                title: "Download As Page Image",
                                icon: "eicon-image",
                                callback: function () {
                                    elementor.selection.getElements(a.getContainer()).forEach(function (e) {
                                    html2canvas(e.document.$element[0], { allowTaint: !0, useCORS: !0 }).then(function (e) {
                                        var n = document.createElement("a");
                                        document.body.appendChild(n),
                                            (n.download = Math.floor(Date.now() / 1e3) + "-" + a.model.get("elType") + "-" + a.model.get("id") + ".png"),
                                            (n.href = e.toDataURL()),
                                            (n.target = "_blank"),
                                            n.click();
                                    });
                                });
                                },
                           
                            },
                        ],
                    }),
                    t
                );
            });
        });
    });
})(jQuery);
