<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<style>
scrollbar-color: #ff000000;
</style>

</head>
<body>
<div style="padding-left: 1em;">
<h4>Network Test</h4>
<sub>Select a button to display the ouput of the test</sub>
<hr>

<div class="jumbotron">

<?php
        if(array_key_exists('pingtest', $_POST)) {
                pingTest();
        }
        else if(array_key_exists('hostname', $_POST)) {
                hostnameTest();
        }
        else if (array_key_exists('ifconfig', $_POST)) {
                ifconfigTest();
        }
        else if (array_key_exists('customCommand', $_POST)) {
                submitCustom();
        }
        else if (array_key_exists('bluetoothTest', $_POST)) {
                bluetoothTest();
        }
        else if (array_key_exists('tracerouteTest', $_POST)) {
                tracerouteTest();
        }
        else if (array_key_exists('arpscanTest', $_POST)) {
                arpscanTest();
        }
        else if (array_key_exists('virtualDisplay', $_POST)) {
                virtualDisplayStart();
        }
        function pingTest() {
                $pingOutput = shell_exec('ping iu.edu -w 2 | sed \'s/ttl=//\' | sed \'s/icmp_seq=//\' | sed \'s/time=//\' | grep -v "rtt min"');
                echo "<pre>$pingOutput</pre>";
        }

        function hostnameTest() {
                $hostnameOutput = shell_exec('hostname');
                echo "Hostname: <pre>$hostnameOutput</pre>";
        }

        function ifconfigTest() {
                $ifconfigOutputHead = shell_exec('ifconfig | head -n 9 | grep -v TX | grep -v RX | grep -v loop | grep -v inet6');
                    echo "<pre>$ifconfigOutputHead</pre>";
                $ifconfigOutputHead = shell_exec('ifconfig | tail -n 10 | grep -v TX | grep -v RX | grep -v loop | grep -v inet6');
                    echo "<pre>$ifconfigOutputHead</pre>";
        }

        function bluetoothTest() {
                $bluetoothOutput = shell_exec('hcitool scan');
                echo "<pre>$bluetoothOutput</pre>";
        }

        /*function submitCustom() {
                $customOutput = shell_exec($_POST['customCommand']);
                echo "<pre>Output: <br>$customOutput</pre>";
        }
        */

        function tracerouteTest() {
                $tracerouteTestOutput = shell_exec('traceroute iu.edu | grep -v "* * *"');
                echo "<pre>$tracerouteTestOutput<pre>";
        }

        function arpscanTest() {
                $arpscanOutputWlan = shell_exec('echo \'spartacus\' | sudo -S arp-scan -I wlan0 -l | grep -v Ending | grep -v Interface | grep -v Starting | grep -v "88:b1:11" | grep -v packets | sort -u');
                echo "<pre>WLAN: $arpscanOutputWlan</pre>";
        }

        function virtualDisplayStart() {
                echo "Starting Virtual Display... <br>";
                $ipWlan0 = shell_exec('ip addr show wlan0 | grep \'inet \' | awk \'{print$2}\' | cut -f1 -d\'/\'');
                echo "<p>Use $ipWlan0:1 as the address</p>";
        }
?>
<!-- Buttons! -->

</div>
        <form method="post">
        <div class="container">
          <div class="row">

            <div class="col">
                <input type="submit" name="pingtest"
                        class="btn btn-warning" value="Ping IU.edu" />
                <small>(2 seconds)</small>
            </div>

            <div class="col">
              <input type="submit" name="hostname"
                class="btn btn-success" value="Display Hostname" />
            </div>

            <div class="col">
              <input type="submit" name="ifconfig"
                class="btn btn-info" value="ifconfig" />
            </div>

                <div class="col">
              <input type="submit" name="bluetoothTest"
                class="btn btn-primary" value="Bluetooth Scan" />
            </div>

                <div class="col">
                <input type="submit" name="tracerouteTest"
                        class="btn btn-danger" value="Traceroute" />
                        </div>

                <div class="col">
                <input type="submit" name="arpscanTest"
                        class="btn btn-danger" value="arp-scan" />
                        </div>
                </div>
        </div>
        <br>
        <hr>
        <h5>System Functions</h5>
                <div class="row">
                        <div class="col">
                                <input type="submit" name="virtualDisplay"
                                        class="btn btn-dark" value="Start VNC Virtual Screen" />
                          </div>

                        <div class="col">
                                <input type="submit" name="softShutdown"
                                        class="btn btn-dark" value="Shutdown Unit"/>
                                <br>
                                <small>(10 Second Delay)<small>
                          </div>
                        <div class="col">
                                <input type="submit" name="stopShutdown"
                                        class="btn btn-dark" value="Cancel Shutdown" />
                          </div>
                </div>
        </div>
        <br>
        <!--
        <input type="text" name="customCommand"/>
        <button class="btn btn-submit" type="submit" tabindex="0">Submit</button>
        -->
        </form>
</div>
</body>
</html>
