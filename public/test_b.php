<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>JS Bin</title>
        <style type="text/css">
            #status {
                display: table;
                width: 100%;
                height: 500px;
                border: 1px solid black;
            }

            span {
                vertical-align: middle;
                text-align: center;
                margin: 0 auto;
                font-size: 50px;
                font-family: arial;
                color: #ba3fa3;
                display: none;
            }

            #status.main .mainWindow, #status.child .childWindow {
                display: table-cell;
            }

            .mainWindow {
                background-color: #22d86e;
            }

            .childWindow {
                background-color: #70aeff;
            }
			.button {
			  background-color: #f44336; /* Green */
			  border: none;
			  color: white;
			  padding: 15px 32px;
			  text-align: center;
			  text-decoration: none;
			  display: inline-block;
			  font-size: 16px;
			  margin: 4px 2px;
			  cursor: pointer;
			}
        </style>
    </head>
    <body>
		
        <div>
			Screen B
        </div>
		<button class="button" onclick="window.open('https://13.228.197.140/test_a.php');">Link A</button>
  <?php echo date('Y-m-d h:i:s');?>
        <script type="text/javascript">
            // noprotect

            var statusWindow = document.getElementById('status');

            (function(win) {
                //Private variables
                var _LOCALSTORAGE_KEY = 'WINDOW_VALIDATION_B';
                var RECHECK_WINDOW_DELAY_MS = 100;
                var _initialized = false;
                var _isMainWindow = false;
                var _unloaded = false;
                var _windowArray;
                var _windowId;
                var _isNewWindowPromotedToMain = false;
                var _onWindowUpdated;
                var _onChangeToFalse = false;

                function WindowStateManager(isNewWindowPromotedToMain, onWindowUpdated) {
                    //this.resetWindows();
                    _onWindowUpdated = onWindowUpdated;
                    _isNewWindowPromotedToMain = isNewWindowPromotedToMain;
                    _windowId = Date.now().toString();

                    bindUnload();

                    determineWindowState.call(this);

                    _initialized = true;

                    _onWindowUpdated.call(this);
                }

                //Determine the state of the window 
                //If its a main or child window
                function determineWindowState() {
                    var self = this;
                    var _previousState = _isMainWindow;

                    _windowArray = localStorage.getItem(_LOCALSTORAGE_KEY);

                    if (_windowArray === null || _windowArray === "NaN") {
                        _windowArray = [];
                    } else {
                        _windowArray = JSON.parse(_windowArray);
                    }

                    if (_initialized) {
                        //Determine if this window should be promoted
                        if (_windowArray.length <= 1 || (_isNewWindowPromotedToMain ? _windowArray[_windowArray.length - 1] : _windowArray[0]) === _windowId) {
                            _isMainWindow = true;
                        } else {
                            _isMainWindow = false;
                        }
                    } else {
                        if (_windowArray.length === 0) {
                            _isMainWindow = true;
                            _windowArray[0] = _windowId;
                            localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
                        } else {
                            _isMainWindow = false;
                            _windowArray.push(_windowId);
                            localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
                        }
                    }

                    //If the window state has been updated invoke callback
                    if (_previousState !== _isMainWindow) {
                        _onWindowUpdated.call(this);
                    }

                    //Perform a recheck of the window on a delay
                    setTimeout(function() {
                        determineWindowState.call(self);
                    }, RECHECK_WINDOW_DELAY_MS);
                }

                //Remove the window from the global count
                function removeWindow() {
                    var __windowArray = JSON.parse(localStorage.getItem(_LOCALSTORAGE_KEY));
                    for (var i = 0, length = __windowArray.length; i < length; i++) {
                        if (__windowArray[i] === _windowId) {
                            __windowArray.splice(i, 1);
                            break;
                        }
                    }
                    //Update the local storage with the new array
                    localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(__windowArray));
                }

                //Bind unloading events  
                function bindUnload() {
                    win.addEventListener('beforeunload', function() {
                        if (!_unloaded) {
                            removeWindow();
                        }
                    });
                    win.addEventListener('unload', function() {
                        if (!_unloaded) {
                            removeWindow();
                        }
                    });
                }

                WindowStateManager.prototype.isMainWindow = function() {
                    return _isMainWindow;
                }
                ;

                WindowStateManager.prototype.resetWindows = function() {
                    localStorage.removeItem(_LOCALSTORAGE_KEY);
                }
                ;

                win.WindowStateManager = WindowStateManager;
            }
            )(window);

            var WindowStateManager = new WindowStateManager(true,windowUpdated);

            function windowUpdated() {
                //"this" is a reference to the WindowStateManager
                //statusWindow.className = (this.isMainWindow() ? 'main' : 'child');
                if (this.isMainWindow() == true) {
                    _onChangeToFalse = true;
                } else if (_onChangeToFalse == true && this.isMainWindow() == false) {
                	var win = window.open("about:blank", "_self");
                    win.close();
                }
            }
            //Resets the count in case something goes wrong in code
            //WindowStateManager.resetWindows()
        </script>
    </body>
</html>
