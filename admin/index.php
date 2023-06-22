<html>
<head>
  <title>DID Admin</title>
  <style>
    .textfield{font-size:48px;width:120px;padding:5px}
    .status{width:16px;height:16px;border-radius:50%;position:absolute;bottom:2px;right:2px;background:gray}
    .green{background:green;}
    .red{background:red;}
  </style>
</head>

<body>
  <input type="text" class="textfield" maxlength="4" disabled>
  <div id="result"></div>
  <span class="status gray"></span>
  <script src="../jquery-3.7.0.min.js"></script>
  <script src="../moment.min.js"></script>
  <script>
    //const wsUrl = 'ws://www.mrf.kr:8080';
    const wsUrl = 'ws://localhost:8080';
    let ws;

    $(function() {
      const heartbeat = () => {
        clearTimeout(this.pingTimeout);
        this.pingTimeout = setTimeout(() => {
          this.terminate();
        }, 35000);
      };

      const connectWs = () => {
        ws = new WebSocket(wsUrl);
        ws.onopen = function() {
          //heartbeat();
          $('.textfield').prop('disabled', false).focus().select();
          $('.status').removeClass('red').addClass('green');
        };
        //ws.onping = function() { heartbeat(); };
        ws.onmessage = function(e) {
          console.log('message:',e.data);
          const parsed = JSON.parse(e.data);
          if (parsed.type ==='order') {
            $('#result').prepend('<p>[' + moment().format('yyyy-MM-DD HH:mm:ss') + '] ' + parsed.value + '</p>');
          }
        };
        ws.onerror = function(err) {
          console.error('Socket encountered error: ', err, 'Closing socket');
          ws.close();
          $('.status').removeClass('green').addClass('red');
        };
        ws.onclose = function(e) {
          clearTimeout(this.pingTimeout);
          console.log('Socket is closed. Reconnect in 3 second.', e);
          $('.textfield').prop('disabled', true);
          $('.status').removeClass('green').addClass('red');
          setTimeout(function() {
            connectWs();
          }, 3000);
        };
      };
      connectWs();
      $('.textfield').on('keyup', function(e) {
        e.preventDefault();
        if (e.which == 13) {
          const json = {type: 'order', value: $('.textfield').val()};
          console.log('json:',json);
          ws.send(JSON.stringify(json));
          $('.textfield').val('').focus();
        }
      });
    });
  </script>
</body>
</html>
