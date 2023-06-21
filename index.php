<!doctype html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
    <title>HTML</title>
    <style>
      video { max-width: 100%; display: block; position: absolute; left: 0; top: 0; }
      .ann{z-index:100;position:absolute;top:0;left:0;width:400px;height:100%;}
      .newOrders{position:absolute;width:200px;height:100%;left:0px}
      .readyOrders{position:absolute;width:200px;height:100%;left:200px}
      .newOrders .inner{max-height:700px;overflow:hidden}
      .newOrders .inner>div,.readyOrders .inner>div{color:#fff;margin:4px;font-size:27px;padding:10px 0;text-align:center;width:90px;display:inline-block}
      .newOrders .inner>div{background:#cc0000;border:1px solid #000;text-shadow:0px 1px 1px #000}
      .readyOrders .inner>div{background:#00aa00;border:1px solid #000;text-shadow:0px 1px 1px #000}
    </style>
  </head>
<body>
  <div>
    <video muted autoplay loop>
      <source src="season.mp4" type="video/mp4">
      <strong>메뉴보드 준비중입니다.</strong>
    </video>
    <div class="ann">
      <div class="newOrders"><div class="inner"></div></div>
      <div class="readyOrders"><div class="inner"></div></div>
    </div>
    <div id="count" style="position:absolute;bottom:0"></div>
  </div>
  <script src="./jquery-3.7.0.min.js"></script>
  <script>
    $(function() {
      function getOrders() {
        $.ajax({
          //url: 'https://mrf.kr/did/05/orders.php',
          url: 'http://localhost:8888/did/05/orders.php',
          type: 'GET',
          success: function (data, status, xhr) {
            console.log('data:',data);
            //alertify.dismissAll();
            $('.newOrders .inner').empty();
            $('.readyOrders .inner').empty();

            data['n'].map(orderNew => {
               //alertify.message(orderItem['order_number'], 0);
               $('.newOrders .inner').append('<div>' + orderNew['order_number'] + '</div>');
            });
            data['r'].map(orderReady => {
               //alertify.message(orderItem['order_number'], 0);
               $('.readyOrders .inner').append('<div>' + orderReady['order_number'] + '</div>');
            });
          },
          error: function(xhr, status, error) {
            console.error('xhr:',xhr);
            console.error('status:',status);
            console.error('error:',error);
          }
        });

        setTimeout(function() {
          getOrders();
        }, 5000 );
      }

      //getOrders();
      console.log('websocket .');
      var ws = new WebSocket('ws://www.mrf.kr:8080/');
      ws.onopen = function() {
        document.body.style.backgroundColor = '#cfc';
      };
      ws.onclose = function() {
        document.body.style.backgroundColor = null;
      };
      ws.onmessage = function(event) {
        document.getElementById('count').textContent = event.data;
      };
    });
  </script>
</body>
</html>