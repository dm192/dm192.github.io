<!DOCTYPE html>

<html>

<head>

  <title>网页终端</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>

    /* 设置背景颜色和字体颜色 */

    body {

      background-color: black;

      color: white;

    }

    

    /* 设置终端框的样式 */

    #terminal {

      width: 100%;

      height: 300px;

      margin: 50px 0;

      border-radius: 10px;

      overflow: auto;

      padding: 10px;

      font-family: monospace;

    }

    

    /* 设置输入框的样式 */

    #input {

      width: 100%;

      height: 30px;

      border: none;

      background-color: transparent;

      outline: none;

      color: white;

      font-size: 16px;

    }

    

    /* 改变输入框获得焦点时的边框样式 */

    #input:focus {

      border: none;

      outline: none;

    }

    /* 针对手机屏幕的样式调整 */

    @media only screen and (max-width: 480px) {

      #terminal {

        height: 150px;

      }

      #input {

        height: 50px;

      }

    }

  </style>

</head>

<body>

  <div id="terminal"></div>

  <form method="post">

    <input type="text" name="host" placeholder="请输入SSH地址" required>

    <input type="text" name="port" placeholder="请输入SSH端口号" value="22">

    <input type="text" name="username" placeholder="请输入用户名" required>

    <input type="password" name="password" placeholder="请输入密码" required>

    <input type="text" id="input" name="command" placeholder="请输入指令" required>

    <button type="submit">发送</button>

  </form>

  <!-- 引入WebSSH脚本 -->

  <script src="https://unpkg.com/webssh"></script>

  <script>

    var terminal = document.getElementById("terminal");

    var form = document.querySelector("form");

    // 提交表单时启动WebSSH会话

    form.addEventListener("submit", function(event) {

      event.preventDefault();

      var host = form.host.value;

      var port = parseInt(form.port.value, 10);

      var username = form.username.value;

      var password = form.password.value;

      var ssh = new WebSSH({

        host: host,

        port: port,

        username: username,

        password: password,

        // 终端选项

        term: {

          cols: 80,

          rows: 24,

          cursorBlink: true,

          scrollback: 1000

        },

        // 实时响应终端输出

        onData: function(data) {

          appendText(data);

        }

      });

      // 监听输入框

      document.getElementById("input").addEventListener("keydown", function(event) {

        if (event.keyCode === 13) {

          event.preventDefault();

          var command = this.value;

          ssh.write(command + "\r");

          this.value = "";

        }

      });

    });

    // 将输出添加到终端框中

    function appendText(text) {

      var node = document.createTextNode(text);

      terminal.appendChild(node);

      terminal.scrollTop = terminal.scrollHeight;

    }

  </script>

</body>

</html>
