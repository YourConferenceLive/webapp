var canvas=document.getElementById("renderCanvas");
var controlPanel=document.getElementById("controlPanel");
var cameraPanel=document.getElementById("cameraPanel");
var divFps=document.getElementById("fps");
var divMensaje=document.getElementById("mensaje");
var aboutPanel=document.getElementById("aboutPanel");
var enableDebug=document.getElementById("enableDebug");
var status=document.getElementById("status");
var fullscreen=document.getElementById("fullscreen");
var touchCamera=document.getElementById("touchCamera");
var deviceOrientationCamera=document.getElementById("deviceOrientationCamera");
var gamepadCamera=document.getElementById("gamepadCamera");
var virtualJoysticksCamera=document.getElementById("virtualJoysticksCamera");
var anaglyphCamera=document.getElementById("anaglyphCamera");
var camerasList=document.getElementById("camerasList");
var toggleFsaa4=document.getElementById("toggleFsaa4");
var toggleFxaa=document.getElementById("toggleFxaa");
var toggleBandW=document.getElementById("toggleBandW");
var toggleSepia=document.getElementById("toggleSepia");
var sceneChecked;
var sceneLocation="http://localhost/tests/2/scene/";
//var sceneLocation="https://www.realidadaumentada.ar/demos/tests/2/scene/";
var engine=new BABYLON.Engine(canvas,true,{preserveDrawingBuffer:true});
var scene;
var previousPickedMesh;
var toques=0;

//Evento para capturar los clicks sobre cualquier cosa
//window.addEventListener("click", function (e) {
    $(window).click(function(e) {
    var pickResult = scene.pick(scene.pointerX, scene.pointerY);
    console.log(pickResult.pickedMesh.id);
    toques++;
    e.preventDefault();

    if(pickResult.pickedMesh.id=='STAND_MOBILE001_primitive10')
    {
        downloadURI("https://www.realidadaumentada.ar/demos/tests/2/assets/iphone11.pdf","Info iphone");
    }

    if(pickResult.pickedMesh.id=="ENTRADA AUDITORIO_primitive0")
    {
        window.location.assign("auditorio.html");
        //alert("entramos al auditorio");
    }
    if(pickResult.pickedMesh.id=="ECOMMERCE")
    {        
        window.open("https://e.toyota.com.ar/inventory");
        //alert("entramos al auditorio");
    }
    
    //abripopup(pickResult.pickedMesh.id+" - "+toques);
    return false;
    //window.off('click');
    //alert("En lugar de tocar " + pickResult.pickedMesh.id + " tocate el culo. ("+toques+")");
});

function downloadURI(uri, name) 
{
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    link.click();
}

var onPointerDown=function(evt,pickResult)
{if(!panelIsClosed)
    {
    panelIsClosed=true;
    controlPanel.style.webkitTransform="translateY(100px)";
    controlPanel.style.transform="translateY(100px)"
    }
    if(pickResult.hit){
        if(evt.ctrlKey){
            status.innerHTML="Selected object: "+pickResult.pickedMesh.name+"("+pickResult.pickedPoint.x+","+pickResult.pickedPoint.y+","+pickResult.pickedPoint.z+")";
            if(previousPickedMesh){
                previousPickedMesh.showBoundingBox=false
            }
            pickResult.pickedMesh.showBoundingBox=true;
            var particleSystem=new BABYLON.ParticleSystem("particles",400,scene);
            particleSystem.particleTexture=new BABYLON.Texture("Assets/Flare.png",scene);
            particleSystem.minAngularSpeed=-.5;
            particleSystem.maxAngularSpeed=.5;
            particleSystem.minSize=.1;
            particleSystem.maxSize=.5;
            particleSystem.minLifeTime=.5;
            particleSystem.maxLifeTime=2;
            particleSystem.minEmitPower=.5;
            particleSystem.maxEmitPower=1;
            particleSystem.emitter=pickResult.pickedPoint;
            particleSystem.emitRate=400;
            particleSystem.blendMode=BABYLON.ParticleSystem.BLENDMODE_ONEONE;
            particleSystem.minEmitBox=new BABYLON.Vector3(0,0,0);
            particleSystem.maxEmitBox=new BABYLON.Vector3(0,0,0);
            particleSystem.direction1=new BABYLON.Vector3(-1,-1,-1);
            particleSystem.direction2=new BABYLON.Vector3(1,1,1);
            particleSystem.color1=new BABYLON.Color4(1,0,0,1);
            particleSystem.color2=new BABYLON.Color4(0,1,1,1);
            particleSystem.gravity=new BABYLON.Vector3(0,-5,0);
            particleSystem.disposeOnStop=true;
            particleSystem.targetStopDuration=.1;
            particleSystem.start();
            previousPickedMesh=pickResult.pickedMesh
        }
        else
        {
            var dir=pickResult.pickedPoint.subtract(scene.activeCamera.position);
            dir.normalize();
            pickResult.pickedMesh.applyImpulse(dir.scale(10),pickResult.pickedPoint);
            status.innerHTML=""
        }
    }
};

//funcion que carga la escena
var loadScene=function(name,incremental,sceneLocation,then)
{
    sceneChecked=false;
    
    BABYLON.SceneLoader.ForceFullSceneLoadingForIncremental=true;
    engine.resize();
    var dlCount=0;

    //BABYLON.SceneLoader.Load(sceneLocation+name+"/",name+incremental+".babylon",engine,function(newScene)
    BABYLON.SceneLoader.Load(sceneLocation,name,engine,function(newScene)
    {

        //piso
        var ground = BABYLON.Mesh.CreatePlane("ground", 200, newScene);
        var material1 = new BABYLON.StandardMaterial("mat1", newScene);
        material1.diffuseColor = new BABYLON.Color3(1, 1, 1);
        ground.material=material1;

        ground.position = new BABYLON.Vector3(5, 0, -15);
        ground.rotation = new BABYLON.Vector3(Math.PI / 2, 0, 0);

        ground.checkCollisions = true;

        scene=newScene;
        //var scene = new BABYLON.Scene(engine);

        //var light0 = new BABYLON.DirectionalLight("Luz1", new BABYLON.Vector3(-2, 40, 2), scene);
        //var light1 = new BABYLON.PointLight("Luz2", new BABYLON.Vector3(2, 60, -2), scene);
        //var light = new BABYLON.HemisphericLight("HemiLight", new BABYLON.Vector3(0, 20, 0), scene);

 
        // Skybox
        var skybox = BABYLON.MeshBuilder.CreateBox("skyBox", {size:1000.0}, scene);
        var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
        skyboxMaterial.backFaceCulling = false;
        skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("assets/skybox", scene);
        skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
        skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
        skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
        skybox.material = skyboxMaterial;	
    
        // Need a free camera for collisions            
        var camera = new BABYLON.FreeCamera("Camera01", new BABYLON.Vector3(91, 2, -1), scene);
        camera.setTarget(BABYLON.Vector3.Zero());
        
        camera.attachControl(canvas, true);
        camera.speed = 0.2;
        camera.angularSpeed = 0.05;
        camera.angle = Math.PI/2;
        camera.direction = new BABYLON.Vector3(Math.cos(camera.angle), 0, Math.sin(camera.angle));
        
        //camera.inputs.addMouse();

        ///////////////////////////////
        camera.inputs.removeByType("FreeCameraKeyboardMoveInput");

        var FreeCameraKeyboardRotateInput = function() {
            this._keys = [];
            this.keysUp = [38];
            this.keysDown = [40];
            this.keysLeft = [37];
            this.keysRight = [39];
            this.sensibility = 0.01;
        };

        FreeCameraKeyboardRotateInput.prototype.getTypeName = function() {
            return "FreeCameraKeyboardRotateInput";
        };
        FreeCameraKeyboardRotateInput.prototype.getSimpleName = function() {
            return "keyboardRotate";
        };

        FreeCameraKeyboardRotateInput.prototype.attachControl = function(
            element,
            noPreventDefault
          ) {
            var _this = this;
            if (!this._onKeyDown) {
              element.tabIndex = 1;
              this._onKeyDown = function(evt) {
                if (_this.keysUp.indexOf(evt.keyCode) !== -1 ||
                    _this.keysDown.indexOf(evt.keyCode) !== -1 ||
                    _this.keysLeft.indexOf(evt.keyCode) !== -1 ||
                    _this.keysRight.indexOf(evt.keyCode) !== -1
                ) {
                  var index = _this._keys.indexOf(evt.keyCode);
                  if (index === -1) {
                    _this._keys.push(evt.keyCode);
                  }
                  if (!noPreventDefault) {
                    evt.preventDefault();
                  }
                }
              };
              this._onKeyUp = function(evt) {
                if (
                    _this.keysUp.indexOf(evt.keyCode) !== -1 ||
                    _this.keysDown.indexOf(evt.keyCode) !== -1 ||
                    _this.keysLeft.indexOf(evt.keyCode) !== -1 ||
                    _this.keysRight.indexOf(evt.keyCode) !== -1
                ) {
                  var index = _this._keys.indexOf(evt.keyCode);
                  if (index >= 0) {
                    _this._keys.splice(index, 1);
                  }
                  if (!noPreventDefault) {
                    evt.preventDefault();
                  }
                }
              };
          
              element.addEventListener("keydown", this._onKeyDown, false);
              element.addEventListener("keyup", this._onKeyUp, false);
              BABYLON.Tools.RegisterTopRootEvents(canvas, [
                { name: "blur", handler: this._onLostFocus }
              ]);
            }
        };
          
        FreeCameraKeyboardRotateInput.prototype.detachControl = function(element) {
            if (this._onKeyDown) {
              element.removeEventListener("keydown", this._onKeyDown);
              element.removeEventListener("keyup", this._onKeyUp);
              BABYLON.Tools.UnregisterTopRootEvents(canvas, [
                { name: "blur", handler: this._onLostFocus }
              ]);
              this._keys = [];
              this._onKeyDown = null;
              this._onKeyUp = null;
            }
        };
        
        FreeCameraKeyboardRotateInput.prototype.checkInputs = function() {
            if (this._onKeyDown) {
              var camera = this.camera;
              // Keyboard
              for (var index = 0; index < this._keys.length; index++) {
                var keyCode = this._keys[index];
                var speed = 0.02;

                //if (this.keysLeft.indexOf(keyCode) !== -1) {
                //  camera.cameraRotation.y += this.sensibility;
                //} else if (this.keysRight.indexOf(keyCode) !== -1) {
                //  camera.cameraRotation.y -= this.sensibility;
                //}

                if (this.keysLeft.indexOf(keyCode) !== -1) {
                    camera.rotation.y -= camera.angularSpeed;
                    camera.direction.copyFromFloats(0, 0, 0);                
                }
                else if (this.keysUp.indexOf(keyCode) !== -1) {
                    camera.direction.copyFromFloats(0, 0, speed);               
                }
                else if (this.keysRight.indexOf(keyCode) !== -1) {
                    camera.rotation.y += camera.angularSpeed;
                    camera.direction.copyFromFloats(0, 0, 0);
                }
                else if (this.keysDown.indexOf(keyCode) !== -1) {
                    camera.direction.copyFromFloats(0, 0, -speed);
                }
                if (camera.getScene().useRightHandedSystem) {
                    camera.direction.z *= -1;
                }

                camera.getViewMatrix().invertToRef(camera._cameraTransformMatrix);
                BABYLON.Vector3.TransformNormalToRef(camera.direction, camera._cameraTransformMatrix, camera._transformedDirection);
                camera.cameraDirection.addInPlace(camera._transformedDirection);

            }
            }
        };

        //Add the onLostFocus function
        FreeCameraKeyboardRotateInput.prototype._onLostFocus = function (e) {
            this._keys = [];
        };
        
        //Add the two required functions for the control Name
        FreeCameraKeyboardRotateInput.prototype.getTypeName = function () {
            return "FreeCameraKeyboardRotateInput";
        };

        FreeCameraKeyboardRotateInput.prototype.getSimpleName = function () {
            return "keyboard";
        };


        //camera.inputs.add(new FreeCameraKeyboardRotateInput());
        camera.inputs.add(new FreeCameraKeyboardRotateInput());

        //The Mouse Manager to use the mouse (touch) to search around including above and below
        var FreeCameraSearchInput = function (touchEnabled) {
            if (touchEnabled === void 0) { touchEnabled = true; }
            this.touchEnabled = touchEnabled;
            this.buttons = [0, 1, 2];
            this.angularSensibility = 2000.0;
            this.restrictionX = 100;
            this.restrictionY = 60;
        }


        ///////////////////////////////

        camera.applyGravity = true;            
        camera.checkCollisions = true;
        camera.ellipsoid = new BABYLON.Vector3(1, .9, 1);
        scene.collisionsEnabled = true;

        
        camera.onCollide = function (colMesh) {
            //if (colMesh.uniqueId === box.uniqueId) {
            //    camera.position = new BABYLON.Vector3(0, -8, -20);
            //}
            if (colMesh.name!="PISO")
            {
                if(colMesh.name=="ENTRADA AUDITORIO_primitive0")
                {
                    window.location.assign("auditorio.html");
                    //alert("entramos al auditorio");
                }    
                //alert(colMesh.name);
                divMensaje.innerHTML="Chocaste con: "+colMesh.name;
            }
        }

        scene.executeWhenReady(function()
        {
            canvas.style.opacity=1;
            
            scene.meshes.forEach(function(m) {
                //m.material = shaderMaterial;
                m.checkCollisions = true;
                //alert (m);        
            });  
            
            if(is_touch_device())
            {
              var camera=new BABYLON.TouchCamera("touchCamera",scene.activeCamera.position,scene);
              switchCamera(camera)
            };            

            
            // Light
            var light = new BABYLON.HemisphericLight("Luz", new BABYLON.Vector3(0, 10, 0), scene);


            ///////video//////////////////
    
            // Video plane
            //var videoPlane = BABYLON.Mesh.CreatePlane("Screen", 10, scene);
            //videoPlane.position = new BABYLON.Vector3(14, 5, 19.5);
            //videoPlane.rotation = new BABYLON.Vector3(0, 0, 3.157894);
            //var mat = new BABYLON.StandardMaterial("mat", scene);
            //var videoTexture = new BABYLON.VideoTexture("video", "assets/pablito.mp4", scene, true, false);
            //mat.diffuseTexture = videoTexture;
            //videoPlane.material = mat;
            
            var videoPlane2 = BABYLON.Mesh.CreatePlane("Toyota", 10, scene);
            videoPlane2.position = new BABYLON.Vector3(11.8,2, -14);
            videoPlane2.rotation = new BABYLON.Vector3(0, Math.PI, Math.PI);
            videoPlane2.scaling = new BABYLON.Vector3(.5,.25,.25)
            var mat2 = new BABYLON.StandardMaterial("mat2", scene);
            var videoTexture2 = new BABYLON.VideoTexture("video2", "assets/toyota.mp4", scene, true, true);

            mat2.diffuseTexture = videoTexture2;
            videoPlane2.material = mat2;
           
            scene.onPointerUp = function () {
                //videoTexture.video.play();
                videoTexture2.video.play();
            }
            
            ///////////////////////////////////////

            //pone el foco en el canvas para poder manejar sin hacer click en la escena
            //document.getElementById('renderCanvas').focus();


            if(scene.activeCamera){
                scene.activeCamera.attachControl(canvas);
                scene.createDefaultEnvironment();
                
                if(newScene.activeCamera.keysUp)
                {
                    newScene.activeCamera.keysUp.push(90);
                    newScene.activeCamera.keysUp.push(87);
                    newScene.activeCamera.keysDown.push(83);
                    newScene.activeCamera.keysLeft.push(65);
                    newScene.activeCamera.keysLeft.push(81);
                    newScene.activeCamera.keysRight.push(69);
                    newScene.activeCamera.keysRight.push(68);
                }
            }
            if(then){
                then();
            }
            })
    },
    function(evt)
    {
        if(evt.lengthComputable)
        {
            engine.loadingUIText="Cargando, por favor espere..."+(evt.loaded*100/evt.total).toFixed()+"%";
        }
        else
        {
            dlCount=evt.loaded/(1024*1024);
            engine.loadingUIText="Cargando, por favor espere..."+Math.floor(dlCount*100)/100+" MB cargados.";
        }
    });
    canvas.style.opacity=0
};




var renderFunction=function()
{
    divFps.innerHTML=engine.getFps().toFixed()+" fps";
    if(scene)
    {
        if(!sceneChecked)
        {
            var remaining=scene.getWaitingItemsCount();
            engine.loadingUIText="Transmitiendo items..."+(remaining?remaining+" restan":"");
            if(remaining===0)
            {
                sceneChecked=true
            }
        }
        scene.render();
        if(scene.useDelayedTextureLoading)
        {
            var waiting=scene.getWaitingItemsCount();
            if(waiting>0)
            {
                status.innerHTML="Transmitiendo items..."+waiting+" restan";
            }
            else
            {
                status.innerHTML="";
            }
        }
    }
};

engine.runRenderLoop(renderFunction);


function abripopup(mensajex){
    mensax=document.getElementById("mensajex");    
    mensax.innerHTML="Tocaste: "+mensajex;    
    //document.getElementById("hover_bkgr_fricc").style.visibility = "visible";
    //document.getElementById("hover_bkgr_fricc").style.display = "block";
    $("#hover_bkgr_fricc").show();
    
};

document.getElementById("popupCloseButton").addEventListener("click",function()
{
    //preventDefault();
    $("#hover_bkgr_fricc").hide();
    //document.getElementById("hover_bkgr_fricc").style.visibility = "hidden";
    document.getElementById('renderCanvas').focus();
    alert("mierda");
    return false;   
});


window.addEventListener("resize",function()
{
    engine.resize()
});

var panelIsClosed=true;
var cameraPanelIsClosed=true;
var aboutIsClosed=true;

function is_touch_device() {  
    try {  
      document.createEvent("TouchEvent");  
      return true;  
    } catch (e) {  
      return false;  
    }  
  }
  
document.getElementById("clickableTag").addEventListener("click",function()
{
    if(panelIsClosed)
    {
        panelIsClosed=false;
        controlPanel.style.webkitTransform="translateY(0px)";
        controlPanel.style.transform="translateY(0px)";
    }
    else
    {
        panelIsClosed=true;
        controlPanel.style.webkitTransform="translateY(100px)";
        controlPanel.style.transform="translateY(100px)";
    }
});

document.getElementById("cameraClickableTag").addEventListener("click",function()
{
    if(cameraPanelIsClosed)
    {
        cameraPanelIsClosed=false;
        cameraPanel.style.webkitTransform="translateX(0px)";
        cameraPanel.style.transform="translateX(0px)";
    }
    else{hideCameraPanel()
    }
});

document.getElementById("notSupported").addEventListener("click",function()
{
    document.getElementById("notSupported").className="hidden";
});

var hideCameraPanel=function(){
    cameraPanelIsClosed=true;
    cameraPanel.style.webkitTransform="translateX(17em)";
    cameraPanel.style.transform="translateX(17em)";
};

enableDebug.addEventListener("click",function()
{
    if(scene)
    {
        if(scene.debugLayer.isVisible())
        {
            scene.debugLayer.hide();
        }
        else
        {
            scene.debugLayer.show();
        }
    }
});

fullscreen.addEventListener("click",function()
{
    if(engine)
    {
        engine.switchFullscreen(true)
    }
});

var switchCamera=function(camera)
{
    if(scene.activeCamera.rotation)
    {
        camera.rotation=scene.activeCamera.rotation.clone();
    }
    camera.fov=scene.activeCamera.fov;
    camera.minZ=scene.activeCamera.minZ;
    camera.maxZ=scene.activeCamera.maxZ;
    if(scene.activeCamera.ellipsoid)
    {
        camera.ellipsoid=scene.activeCamera.ellipsoid.clone();
    }
    camera.checkCollisions=scene.activeCamera.checkCollisions;
    camera.applyGravity=scene.activeCamera.applyGravity;
    camera.speed=scene.activeCamera.speed;
    camera.postProcesses=scene.activeCamera.postProcesses;
    scene.activeCamera.postProcesses=[];
    scene.activeCamera.detachControl(canvas);
    if(scene.activeCamera.dispose)scene.activeCamera.dispose();
    scene.activeCamera=camera;
    scene.activeCamera.attachControl(canvas);

    
    hideCameraPanel()
};

touchCamera.addEventListener("click",function()
{
    if(!scene)
    {
        return;
    }
    if(scene.activeCamera instanceof BABYLON.TouchCamera)
    {
        return;
    }
    var camera=new BABYLON.TouchCamera("touchCamera",scene.activeCamera.position,scene);
    switchCamera(camera)
});

gamepadCamera.addEventListener("click",function()
{
    if(!scene)
    {
        return;
    }
    if(scene.activeCamera instanceof BABYLON.GamepadCamera)
    {
        return;
    }
    var camera=new BABYLON.GamepadCamera("gamepadCamera",scene.activeCamera.position,scene);
    switchCamera(camera)
});
virtualJoysticksCamera.addEventListener("click",function()
{
    if(!scene){
        return;
    }
    if(scene.activeCamera instanceof BABYLON.VirtualJoysticksCamera)
    {
        return;
    }
    var camera=new BABYLON.VirtualJoysticksCamera("virtualJoysticksCamera",scene.activeCamera.position,scene);
    switchCamera(camera)
});
anaglyphCamera.addEventListener("click",function()
{
    if(!scene)
    {
        return;
    }
    if(scene.activeCamera instanceof BABYLON.AnaglyphArcRotateCamera)
    {
        return;
    }
    var camera=new BABYLON.AnaglyphFreeCamera("anaglyphCamera",scene.activeCamera.position,.2,scene);
    switchCamera(camera)
});
deviceOrientationCamera.addEventListener("click",function()
{
    if(!scene)
    {
        return;
    }
    if(scene.activeCamera instanceof BABYLON.VRDeviceOrientationFreeCamera)
    {
        return;
    }
    var camera=new BABYLON.VRDeviceOrientationFreeCamera("deviceOrientationCamera",scene.activeCamera.position,scene);
    switchCamera(camera)
});
toggleBandW.addEventListener("click",function()
{
    if(scene&&scene.activeCamera)
    {
        if(scene.activeCamera.__bandw_cookie)
        {
            scene.activeCamera.__bandw_cookie.dispose(),scene.activeCamera.__bandw_cookie=null;
            toggleBandW.className="smallButtonControlPanel"
        }
        else
        {
            scene.activeCamera.__bandw_cookie=new BABYLON.BlackAndWhitePostProcess("bandw",1,scene.activeCamera);
            toggleBandW.className="smallButtonControlPanel pushed"
        }
    }
});
toggleFxaa.addEventListener("click",function()
{
    if(scene&&scene.activeCamera)
    {
        if(scene.activeCamera.__fxaa_cookie)
        {
            scene.activeCamera.__fxaa_cookie.dispose(),scene.activeCamera.__fxaa_cookie=null;
            toggleFxaa.className="smallButtonControlPanel";
        }
        else
        {
            scene.activeCamera.__fxaa_cookie=new BABYLON.FxaaPostProcess("fxaa",1,scene.activeCamera);
            toggleFxaa.className="smallButtonControlPanel pushed"
        }
    }
});
toggleFsaa4.addEventListener("click",function()
{
    if(scene&&scene.activeCamera)
    {
        if(scene.activeCamera.__fsaa_cookie)
        {
            scene.activeCamera.__fsaa_cookie.dispose(),scene.activeCamera.__fsaa_cookie=null;
            toggleFsaa4.className="smallButtonControlPanel";
        }
        else
        {
            var fx=new BABYLON.PassPostProcess("fsaa",2,scene.activeCamera);
            fx.renderTargetSamplingMode=BABYLON.Texture.BILINEAR_SAMPLINGMODE;
            scene.activeCamera.__fsaa_cookie=fx;
            toggleFsaa4.className="smallButtonControlPanel pushed"
        }
    }
});
toggleSepia.addEventListener("click",function()
{
    if(scene&&scene.activeCamera)
    {
        if(scene.activeCamera.__sepia_cookie)
        {
            scene.activeCamera.__sepia_cookie.dispose(),scene.activeCamera.__sepia_cookie=null;
            toggleSepia.className="smallButtonControlPanel"
        }
        else
        {
            var sepiaKernelMatrix=BABYLON.Matrix.FromValues(.393,.349,.272,0,.769,.686,.534,0,.189,.168,.131,0,0,0,0,0);
            scene.activeCamera.__sepia_cookie=new BABYLON.FilterPostProcess("Sepia",sepiaKernelMatrix,1,scene.activeCamera);
            toggleSepia.className="smallButtonControlPanel pushed"
        }
    }
});
camerasList.addEventListener("change",function()
{
    if(scene)
    {
        scene.activeCamera.detachControl(canvas);
        scene.activeCamera=scene.cameras[camerasList.selectedIndex];
        scene.activeCamera.attachControl(canvas);
    }
});
if(!BABYLON.Engine.isSupported())
{
    document.getElementById("notSupported").className="";
}
else
{
    //if(window.location.hostname.indexOf("localhost")===-1&&!demo.forceLocal)
    //{
    //    if(demo.doNotUseCDN)
    //    {
    //        sceneLocation="/Scenes/";
    //    }
    //    else
    //    {
    //        sceneLocation="/Scenes/";
    //    }
    //}
    var mode="";
    if(demo.incremental)
    {
        mode=".incremental";
    }
    else if(demo.binary)
    {
        mode=".binary";
    }
    if(demo.offline)
    {
        engine.enableOfflineSupport=true;
    }
    else
    {
        engine.enableOfflineSupport=false;
    }
    loadScene(demo.scene,mode,sceneLocation,function()
    {
        BABYLON.StandardMaterial.BumpTextureEnabled=true;
        if(demo.collisions!==undefined)
        {
            scene.collisionsEnabled=demo.collisions;
        }
        if(demo.onload)
        {
            demo.onload();
        }
        for(var index=0;index<scene.cameras.length;index++)
        {
            var camera=scene.cameras[index];
            var option=new Option;
            option.text=camera.name;
            option.value=camera;
            if(camera===scene.activeCamera)
            {
                option.selected=true;
            }
            camerasList.appendChild(option);
        }
    })
}
