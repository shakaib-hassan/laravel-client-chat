var BOSH_SERVICE = null;
var connection = null;
var SERVER_NAME = "mxp-blade";
var ROOM_NAME = "lobby";
function log(msg)
{
    console.log(document.createTextNode(msg));
}

function myErrorHandler() {
    $('body').prepend('<span style="color:red">Connection is lost<span>');
}

function onConnect(status)
{
    if (status == Strophe.Status.CONNECTING) {
        log('Strophe is connecting.');
    } else if (status == Strophe.Status.CONNFAIL) {
        log('Strophe failed to connect.');
        $('#connect').get(0).value = 'connect';
    } else if (status == Strophe.Status.DISCONNECTING) {
        log('Strophe is disconnecting.');
    } else if (status == Strophe.Status.DISCONNECTED) {
        log('Strophe is disconnected.');
        $('#connect').get(0).value = 'connect';
    } else if (status == Strophe.Status.CONNECTED) {
        log('Strophe is connected.');

        connection.addHandler(onMessage, null, 'message', null, null, null);
        connection.addHandler(presenceHandler, null, "presence");
        connection.send($pres());
        var room = ROOM_NAME + "@conference." + SERVER_NAME;

        console.log(room);
        var jid = $("#username").val();
        connection.muc.join(room, jid, onMessage, presenceHandler);

    }
}


function onRoomList(list) {

    console.log(list);
}

function onRoomerror(err) {
    console.log(err);
}


function presenceHandler(presence) {
    // body...
    console.log("the presence message is");
    console.log(presence);

    var presence_type = $(presence).attr('type'); // unavailable, subscribed, etc...
    var from = $(presence).attr('from'); // the jabber_id of the contact
    
    console.log(from);
    console.log(presence_type);
    
    debugger;
    
//    http://jabber.org/protocol/muc#user

    
    
    if (presence_type == "subscribe"){
        var request = from.split("@")[0];
        bootbox.confirm(request+" wants to be your friend", function(result) {
             
             if (result){
                 // perform ajax call to add it into the friends table and then send back the xmpp subscribe request
                 $.post("/friends",{to:request},function(res){
                     
                     if (res){
                         debugger;
                        var id = request+"@"+SERVER_NAME;
                        connection.send($pres({ to: id, type: "subscribed" }));
                        $("#lobby-"+request).find(".request").html("<button class='ladda-button' data-color='purple' data-style='contract' disabled='disabled'>Friends</button>");
                        
                     }
                     
                 });
                 
             }else{
                 
                 // cancel the friend request
                 
             }
             
        }); 
        
    }
    
    
    if (presence_type != 'error') {
        from = from.split("/")[1];
        if (presence_type === 'unavailable') {
            // Mark contact as offline
            $("#lobby-"+from).find(".status").html("Offline").removeClass("btn btn-info");    
        } else {
            var show = $(presence).find("show").text(); // this is what gives away, dnd, etc.
            if (show === 'chat' || show === '') {
                // Mark contact as online
                
                $("#lobby-"+from).find(".status").html("Online").addClass("btn btn-info");    
                
            } else {
                // etc...
            }
        }
    }

    return true;
}

function onMessage(msg) {

    console.log("On recieving something")
    console.log(msg);

    //    var to = msg.getAttribute('to');
    //    var from = msg.getAttribute('from');
    //    var type = msg.getAttribute('type');

    var elems = msg.getElementsByTagName('body');

    //    if (type == "chat" && elems.length > 0) {
    var body = elems[0];
    var tbody = "";

    try {

        var jsonbody = body.textContent;

        var jsonarray = JSON.parse(jsonbody);



        for (var pointer in jsonarray) {

            jsonarray[pointer].username;
            jsonarray[pointer].score;

            var klass = pointer % 2 ? "even" : "odd";

            tbody += "<tr calss ='" + klass + "' role = 'row'><td>" + jsonarray[pointer].username + "</td><td>" + jsonarray[pointer].score + "</td></tr>";

        }

        if ($("#leaderboard-sample-table").find("td").hasClass("dataTables_empty")) {
            $("#leaderboard-sample-table").find("td.dataTables_empty:first").parent().remove();
        }

        $("#leaderboard-sample-table tbody").html(tbody);


    } catch (err) {

        console.log("unable to parase message body");
        console.log("message body is " + body);
    }

    // log('ECHOBOT: I got a message from : ' + 
    //     Strophe.serialize(body));

    // console.log(jQuery.parseJSON(body));

    // // var reply = $msg({to: from, from: to, type: 'chat'})
    // //            .cnode(Strophe.copyElement(body));
    // // connection.send(reply.tree());

    // log('ECHOBOT: I sent ' + from + ': ' + Strophe.getText(body));
    // }

    // we must return true to keep the handler alive.  
    // returning false would remove it after it finishes.
    return true;
}

$(document).ready(function () {
    BOSH_SERVICE = "http://" + $("#current-enviroment").val() + ":7070/http-bind/";
    connection = new Strophe.Connection(BOSH_SERVICE);

    // Uncomment the following lines to spy on the wire traffic.
    //connection.rawInput = function (data) { log('RECV: ' + data); };
    //connection.rawOutput = function (data) { log('SEND: ' + data); };

    // Uncomment the following line to see all the debug output.
//    Strophe.log = function (level, msg) { log('LOG: ' + msg); };
    var jid = $("#username").val();

    connection.connect(jid + "@" + SERVER_NAME,
            jid,
            onConnect);




    connection._hitError = function (reqStatus) {
        this.errors++;
        Strophe.warn("request errored, status: " + reqStatus + ", number of errors: " + this.errors);
        if (this.errors > 4)
            this._onDisconnectTimeout();
        myErrorHandler(reqStatus, this.errors);
    };

});


$(window).on('beforeunload', function () {
    connection.disconnect();
})
