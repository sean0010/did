<html>
<head>
    <title>DID Admin</title>
    <style>
        .textfield{font-size:48px;width:120px;padding:5px}
    </style>
</head>

<body>
    <input type="text" class="textfield" maxlength="4">    
    <script src="../jquery-3.7.0.min.js"></script>
    <script>
        $(function() {
            var ws = new WebSocket('ws://www.mrf.kr:8080/');
            ws.onopen = function() {
                console.log('open');
            };
            ws.onclose = function() {
                console.log('close');
            };
            ws.onmessage = function(event) {
                console.log('message:',event.data);
            };

            $('.textfield').focus();
            $('.textfield').on('keyup', function(e) {
                e.preventDefault();
                if (e.which == 13) {
                    console.log('enter. send:', $('.textfield').val());
                    ws.send($('.textfield').val())
                }
            });
        });
    </script>
</body>
</html>
