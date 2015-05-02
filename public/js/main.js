/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$("document").ready(function () {

    $(".request").on("click", ".ladda-button", function () {

        var parent = $(this);
        var l = Ladda.create($(this)[0]);
        l.toggle();


        var containerid = $(this).parents(".row").attr("id");
        var id = containerid.split("-")[1];
        var to = id + "@" + SERVER_NAME;
        $.post("/requests", {to: id}, function (res) {

            if (res) {
                l.toggle();
                parent.html("SENT");
                parent.attr("disabled", "disabled");
                connection.send($pres({to: to, type: "subscribe"}));
            }

        })

//       alert("request sent");
    })
});