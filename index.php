<!doctype html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
    <title>HTML</title>
    <style>
      video{max-width: 100%; display: block; position: absolute; left: 0; top: 0;}
      .ann{z-index:1000;position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-size:50px;color:white;background:#e00;min-width:100px;text-align:center;display:inline-block;}
      .status{width:16px;height:16px;border-radius:50%;position:absolute;bottom:2px;right:2px;background:gray;}
      .green{background:green;}
      .red{background:red;}
      .blink {
        animation: blink 1s steps(1, end) 3;
      }
      @keyframes blink {
        0% {opacity: 1;}
        70% {opacity: 0;}
        100% {opacity: 1;}
      }
    </style>
  </head>
<body>
  <div>
    <video muted autoplay loop>
      <source src="season.mp4" type="video/mp4">
      <strong>메뉴보드 준비중입니다.</strong>
    </video>
    <div class="ann"></div>
    <audio id="dingDongAudio" controls autoplay="false" preload="auto">
      <source src="./ding.wav" type="audio/wav">
    </audio>
    <div class="status"></div>
  </div>
  <script src="./jquery-3.7.0.min.js"></script>
  <script>
    //const wsUrl = 'ws://www.mrf.kr:8080';
    const wsUrl = 'ws://localhost:8080';
    let ws;

    const ding = new Audio('ding.wav');    

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
          $('.status').removeClass('red').addClass('green');
        };
        //ws.onping = function() { heartbeat(); };
        ws.onmessage = function(e) {
          console.log('message:',e.data);
          const parsed = JSON.parse(e.data);
          if (parsed.type ==='order') {
            document.getElementById('dingDongAudio').play();

            $('.ann').text(parsed.value).addClass('blink');
            setTimeout(function() {
              $('.ann').removeClass('blink').text('');
            }, 5000);
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
    });
  </script>
</body>
</html>