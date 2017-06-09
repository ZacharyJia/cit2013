<html>
<head>
    <script src="/awesome-qr.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<style>
    #qrcode {
        height: 200px;
        width: 200px;
        display: none;
    }
</style>

<img id="qrcode"></img>
<img id="logo" src="/logo.jpg" style="display: none"></img>
<img id="background" src="/back.jpg" style="display: none"></img>
<canvas id="canvas" width="828px" height="425px"></canvas>

<script>

    function saveFile(data, filename) {
        var save_link=document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
        save_link.href=data;
        save_link.download=filename;
        var event = document.createEvent('MouseEvents');
        event.initMouseEvent('click',true,false,window,0,0,0,0,0,false,false,false,false,0,null);
        save_link.dispatchEvent(event);
    }

    var name = "{{ $name }}";
    var id = "{{ $id }}";

    var qrcode = document.getElementById("qrcode");
    var logo = document.getElementById("logo");
    window.onload = function() {
        new AwesomeQRCode().create({
            text: "http://cit2013.bigtomato.cn/user/" + id,
            size: 474,
            backgroundImage: logo,
            backgroundDimming: 'rgba(0,0,0,0)',
            margin: 0,
            bindElement: 'qrcode',
            dotScale: 0.5,
            correctLevel: AwesomeQRCode.CorrectLevel.H,
        });
    }

    qrcode.onload = function() {
        var background = document.getElementById("background");
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext('2d');
        ctx.scale(0.5, 0.5);
        ctx.drawImage(background, 0, 0);
        ctx.drawImage(qrcode, 1043, 164);
        ctx.font = "50px 微软雅黑";
        ctx.fillText(name, 280, 730);
        ctx.fillText(id, 280, 811);
        saveFile(canvas.toDataURL('png').replace("image/png", "image/octet-stream"), id + '.png');

//        var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
//        window.location.href=image;
    }

</script>
</body>

</html>
