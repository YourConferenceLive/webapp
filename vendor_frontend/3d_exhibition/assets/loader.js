var canvas=document.getElementById("renderCanvas");
var controlPanel=document.getElementById("controlPanel");
var cameraPanel=document.getElementById("cameraPanel");
//var divFps=document.getElementById("fps");
var divMensaje=document.getElementById("mensaje");
var aboutPanel=document.getElementById("aboutPanel");
var enableDebug=document.getElementById("enableDebug");
var status=document.getElementById("status");
var stats=document.getElementById("stats");
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
var sceneLocation="https://dev.yourconference.live/vendor_frontend/3d_exhibition/scene/";    
var zoomed=false;

//var engine=new BABYLON.Engine(canvas,true,{preserveDrawingBuffer:true});
//engine = new BABYLON.Engine(canvas, false); // built-in smoothing will be disabled 
var engine = new BABYLON.Engine(canvas, null, null, true);

var scene;
var previousPickedMesh;
var toques=0;
var zoompos=0;


////////////pantalla de preload
var loadingScreenDiv = window.document.getElementById("loadingScreen");
function customLoadingScreen() {
    console.log("customLoadingScreen creation")
}
customLoadingScreen.prototype.displayLoadingUI = function () {
    console.log("customLoadingScreen loading")
    //loadingScreenDiv.innerHTML = "loading";
};
customLoadingScreen.prototype.hideLoadingUI = function () {
    console.log("customLoadingScreen loaded")
    loadingScreenDiv.style.display = "none";
};
var loadingScreen = new customLoadingScreen();
engine.loadingScreen = loadingScreen;
engine.displayLoadingUI();
/////////////////////

/*
if (userid==0)
{
    //stats.innerHTML="Dirijase a la zona de acreditación para poder acceder al evento completo";    
}
else 
{
    //stats.innerHTML="Bienvenido "+nombre;
}    
*/



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
var loadScene=async function(name,incremental,sceneLocation,then)
{
    sceneChecked=false;
    
    BABYLON.SceneLoader.ForceFullSceneLoadingForIncremental=true;
    engine.resize();
    var dlCount=0;


    //BABYLON.SceneLoader.Load(sceneLocation+name+"/",name+incremental+".babylon",engine,function(newScene)
    BABYLON.SceneLoader.Load(sceneLocation,name,engine,function(newScene)
    {

        scene=newScene;       
        
        scene.collisionsEnabled = true;
        

        // Skybox
        //var skybox = BABYLON.MeshBuilder.CreateBox("skyBox", {size:1000.0}, scene);
        //var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
        //skyboxMaterial.backFaceCulling = false;
        //skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("assets/skybox", scene);
        //skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
        //skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
        //skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
        //skybox.material = skyboxMaterial;	

        //camara local
        //(100-camera.radius)*0.014        
        //var camera = new BABYLON.ArcRotateCamera("Camera", 1.5680, BABYLON.Tools.ToRadians(80), 40, BABYLON.Vector3.Zero(), scene);
        var camera = new BABYLON.ArcRotateCamera("Camera", 1.5680, BABYLON.Tools.ToRadians(80), 40, new BABYLON.Vector3(3,0,18.5), scene);
        

        camera.attachControl(canvas, false);
        camera.ellipsoid = new BABYLON.Vector3(2, 2, 2);
        camera.minZ = 0.1;
        camera.upperBetaLimit = BABYLON.Tools.ToRadians(40);

        camera.inputs.removeByType('ArcRotateCameraPointersInput');
        camera.detachControl(canvas);
        addControls(scene, camera);

        // Limit target on render        
        scene.beforeRender = function() {
            
            limitex=42;
            limitez=50;

            /*
            limitex=(50-camera.radius)+10;
            limitez=(50-camera.radius)+10;

            if (camera.radius<20) {
                limitex=42;
                limitez=42;
            }
            if (camera.radius>50) {
                limitex=10;
                limitez=10;
            }
            */
            /*
            if (camera.radius>20 && camera.radius<40) {
                limitex=28;
                limitez=28;
            }
            if (camera.radius>40 && camera.radius<50) {
                limitex=20;
                limitez=20;
            }
            */

            if (camera.target.z > limitez)
                camera.target.z = limitez;
            if (camera.target.z < -limitez)
                camera.target.z = -limitez;
            if (camera.target.x > limitex)
                camera.target.x = limitex;
            if (camera.target.x < -limitex)
                camera.target.x = -limitex;
            //console.log("limite: "+limite+" radius: "+camera.radius);
        };

    //return scene;

        

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
        //camera.inputs.add(new FreeCameraKeyboardRotateInput());

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

        //camera.applyGravity = true;            
        //camera.checkCollisions = true;
        //camera.ellipsoid = new BABYLON.Vector3(.9, .9, 1);
        
        scene.gravity = new BABYLON.Vector3(0, -0.1, 0);
        scene.collisionsEnabled = true;
        //camera.checkCollisions = true;
        
        camera.onCollide = function (colMesh) {
            //if (colMesh.uniqueId === box.uniqueId) {
            //    camera.position = new BABYLON.Vector3(0, -8, -20);
            //}
            if (colMesh.name!="PISO")
            {
                if(colMesh.name=="xxx")
                {                    
                    //alert("aha!");
                }    
                //alert(colMesh.name);
                divMensaje.innerHTML="Chocaste con: "+colMesh.name;
            }
        }

        scene.executeWhenReady(function()
        {
            canvas.style.opacity=1;
            
            //sombra mata la maquina
            //var light1x = new BABYLON.PointLight("light1x", new BABYLON.Vector3(0,70,0), scene);
            //light1x.intensity = .1;

            scene.meshes.forEach(function(m) {
                m.checkCollisions = true;
            });  


            // GUI
            var advancedTexture = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI("UI");
            advancedTexture.idealWidth = 600;

            if(is_touch_device())
            {        
            
                scene.activeCamera.pinchDeltaPercentage = 0.001;
              //var camera=new BABYLON.TouchCamera("touchCamera",scene.activeCamera.position,scene);
              //switchCamera(camera)

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
                    if (userid==0){
                        if (colMesh.name=="Box1407" || colMesh.name=="Box1422")
                        {
                            window.location.assign("register.php");
                        }
                    }
                }

            }
            else
            {
                /*
                scene.meshes.forEach(function(m) {
                    shadowGenerator.getShadowMap().renderList.push(m);                
                    m.receiveShadows = true;
                });                  
                */
            };
            
            // Light
            var light = new BABYLON.HemisphericLight("Luz", new BABYLON.Vector3(0, 10, 0), scene);
            var light1 = new BABYLON.PointLight("Luz1", new BABYLON.Vector3(10, 5, 5), scene);
            //var light2 = new BABYLON.PointLight("Luz2", new BABYLON.Vector3(-10, 5, 5), scene);
            //var light3 = new BABYLON.PointLight("Luz3", new BABYLON.Vector3(10, 5, -15), scene);
            var light4 = new BABYLON.PointLight("Luz4", new BABYLON.Vector3(-10, 5, -15), scene);
            
            light.intensity = 1.8;
            light1.intensity = 300;
            //light2.intensity = 300;
            //light3.intensity = 300;
            light4.intensity = 300;


            var matpant = new BABYLON.StandardMaterial("matpant", scene);
            var videoTexturepant = new BABYLON.VideoTexture("videoclip", "assets/CLIP.mp4", scene, true, true);

            matpant.diffuseTexture = videoTexturepant;

            /*
            p1=scene.getMeshByName("Allergen1-0_primitive1")
            p2=scene.getMeshByName("Allergen2-1_primitive1")
            p3=scene.getMeshByName("Allergen3-1_primitive1")
            p4=scene.getMeshByName("Allergen4-1_primitive1")

            p1.material = matpant;
            p2.material = matpant;
            p3.material = matpant;
            p4.material = matpant;
            */

            var cam = scene.activeCamera;
            var ease = new BABYLON.CubicEase();
            ease.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);

            cam.upperBetaLimit = BABYLON.Tools.ToRadians(85);
            cam.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
            betax=40;
    
            BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, new BABYLON.Vector3(3,0,18.5), 0, ease);
            
            var animo = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'beta', 100, 120, cam.beta, BABYLON.Tools.ToRadians(betax), 0, ease);
            var animo2 = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, 80, 0, ease);
    
            animo.onAnimationEnd = function (){
                cam.upperBetaLimit = BABYLON.Tools.ToRadians(40);
                cam.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
            }
            animo2.onAnimationEnd = function (){
                cam.lowerRadiusLimit = 12;
                cam.upperRadiusLimit = 80;
                zoomed=false;
            }

            
            //BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, new BABYLON.Vector3(-6.02,2.5,42), 0, ease);
            //BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, new BABYLON.Vector3(3,0,18.5), 0, ease);
            
            //BABYLON.Animation.CreateAndStartAnimation('at3', cam, 'radius', 100, 120, cam.radius, 5, 0, ease);
            //BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'alpha', 100, 120, cam.alpha, 1.5680, 0, ease);
            //var animo = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'beta', 100, 120, cam.beta, BABYLON.Tools.ToRadians(85), 0, ease);    
            
            //ppp
            //BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, radiusx, 0, ease);
            
            //animo.onAnimationEnd = function (){
            //    scene.activeCamera.upperBetaLimit = BABYLON.Tools.ToRadians(85);
            //    scene.activeCamera.lowerBetaLimit = BABYLON.Tools.ToRadians(85);
            //}

            //scene.onPointerUp = function () {
            //    videoTexturepant.video.play();
            //    //videoTexture2.video.play();
            //}

            ///////////////////////////////////////

            //pone el foco en el canvas para poder manejar sin hacer click en la escena
            document.getElementById('renderCanvas').focus();


            ///////////////////Detecta los clicks sobre los objetos
            $(window).click(function(e) {
                var pickResult = scene.pick(scene.pointerX, scene.pointerY);
                console.log(pickResult.pickedMesh.id);
                toques++;
                e.preventDefault();
            
                if (zoomed)
                {
                    nombrecito=pickResult.pickedMesh.id;
                    idx=0;
                    if(nombrecito.indexOf('Aequuspharma_pie_enter')>-1) idx=20;
                    if(nombrecito.indexOf('Alcon_pie_enter_18')>-1) idx=47;
                    if(nombrecito.indexOf('Alcon_pie_enter_17')>-1) idx=25;
                    if(nombrecito.indexOf('Allergen_pie_enter_4')>-1) idx=44;
                    if(nombrecito.indexOf('Allergen_pie_enter_5')>-1) idx=56;
                    if(nombrecito.indexOf('Allergen_pie_enter_11')>-1) idx=43;
                    if(nombrecito.indexOf('Allergen_pie_enter_12')>-1) idx=57;
                    if(nombrecito.indexOf('Axis Medical_pie_enter_')>-1) idx=39;
                    if(nombrecito.indexOf('Bausch & Lomb_pie_enter_')>-1) idx=38;
                    if(nombrecito.indexOf('Bayer_pie_enter_')>-1) idx=55;
                    if(nombrecito.indexOf('BioScript_pie_enter_')>-1) idx=37;
                    if(nombrecito.indexOf('Candorvision_pie_enter_')>-1) idx=36;
                    if(nombrecito.indexOf('Clarion Medical_pie_enter_')>-1) idx=24;
                    if(nombrecito.indexOf('Glaukos_pie_enter_')>-1) idx=35;
                    if(nombrecito.indexOf('Innova_pie_enter_26')>-1) idx=53;
                    if(nombrecito.indexOf('Innova_pie_enter_27')>-1) idx=34;
                    if(nombrecito.indexOf('Innova_pie_enter_28')>-1) idx=34;
                    if(nombrecito.indexOf('Ivantis_pie_enter_')>-1) idx=63;
                    if(nombrecito.indexOf('Johnson & Johnson_pie_enter_')>-1) idx=40;
                    if(nombrecito.indexOf('Labtician_pie_enter_1')>-1) idx=33;
                    if(nombrecito.indexOf('Labtician_pie_enter_8')>-1) idx=62;
                    if(nombrecito.indexOf('McKesson_pie_enter_')>-1) idx=35;
                    if(nombrecito.indexOf('MD Financial_pie_enter_')>-1) idx=31;
                    if(nombrecito.indexOf('Natus_pie_enter_')>-1) idx=30;
                    if(nombrecito.indexOf('Novartis_pie_enter_6')>-1) idx=58;
                    if(nombrecito.indexOf('Novartis_pie_enter_7')>-1) idx=41;
                    if(nombrecito.indexOf('Novartis_pie_enter_13')>-1) idx=48;
                    if(nombrecito.indexOf('Novartis_pie_enter_14')>-1) idx=50;
                    if(nombrecito.indexOf('Novartis_pie_enter_20')>-1) idx=49;
                    if(nombrecito.indexOf('Oculus_pie_enter_')>-1) idx=59;
                    if(nombrecito.indexOf('Pacific Surgical_pie_enter_')>-1) idx=42;
                    if(nombrecito.indexOf('Roche_pie_enter_')>-1) idx=0;
                    if(nombrecito.indexOf('Sacor_pie_enter_')>-1) idx=29;
                    if(nombrecito.indexOf('Santen_pie_enter_')>-1) idx=45;
                    if(nombrecito.indexOf('Seaford Pharmaceuticals_pie_enter_')>-1) idx=28;
                    if(nombrecito.indexOf('TopCon_pie_enter_')>-1) idx=27;
                    if(nombrecito.indexOf('Zeiss_pie_enter_')>-1) idx=26;
                    if(nombrecito.indexOf('COS_pie_enter_')>-1) idx=46;

                    if (idx>0)
                    {
                        destino="https://dev.yourconference.live/COS/sponsor/booth/"+idx;
                        window.open(destino, '_blank');
                    }

                }
                    return false;
            });
            ////////////////////////////////////////////////////

            if(scene.activeCamera){
                scene.activeCamera.attachControl(canvas);
                scene.createDefaultEnvironment();
                //scene.environmentTexture = new BABYLON.CubeTexture("assets/skybox2", scene);

                //quita loader
                loadingScreenDiv.innerHTML = "";
                engine.hideLoadingUI();
                
                
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


//captura doble click
var clickCount=0;
window.addEventListener('click', function() {
    clickCount++;
    if (clickCount === 1) {
        singleClickTimer = setTimeout(function() {
            clickCount = 0;
            //singleClick();
            //alert("simple");
        }, 200);
    } else if (clickCount === 2) {
        clearTimeout(singleClickTimer);
        clickCount = 0;
        //alert("doble");
        dobleclick();
    }
}, false);



//scene.constantlyUpdateMeshUnderPointer = true;
//window.addEventListener("dblclick", function (e) {	    
function dobleclick(){
    var cam = scene.activeCamera;
    if (zoomed==false)
    {
        zoomed=true;
        betax=85;
        radiusx=5;
        scene.activeCamera.upperBetaLimit = BABYLON.Tools.ToRadians(85);
        scene.activeCamera.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
        scene.activeCamera.lowerRadiusLimit = 5;
        scene.activeCamera.upperRadiusLimit = 80;

        var pickResult = scene.pick(scene.pointerX, scene.pointerY);     
        
        var ease = new BABYLON.CubicEase();
        ease.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);

        var tocado=pickResult.pickedMesh.name;
        
        var esobject=false;

        if (!tocado.indexOf("Allergen")){
            objetivo = new BABYLON.Vector3(-6.19, 2.5, 50);
            esobject=true;
        }
        if (!tocado.indexOf("Clarion")){
            objetivo = new BABYLON.Vector3(25.216, 2.5, 25.5);
            esobject=true;
        }
        if (!tocado.indexOf("Labtician")){
            objetivo = new BABYLON.Vector3(35.64, 2.5, 50);
            esobject=true;
        }
        if (!tocado.indexOf("Santen")){
            objetivo = new BABYLON.Vector3(19.16, 2.5, 50);
            esobject=true;
        }
        if (!tocado.indexOf("Novartis")){
            objetivo = new BABYLON.Vector3(-30, 2.5, 50);
            esobject=true;
        }
        if (!tocado.indexOf("Johnson")){
            objetivo = new BABYLON.Vector3(25, 2.5, 38);
            esobject=true;
        }
        if (!tocado.indexOf("Bayer")){
            objetivo = new BABYLON.Vector3(12.8, 2.5, 38);
            esobject=true;
        }
        if (!tocado.indexOf("Pacific Surgical")){
            objetivo = new BABYLON.Vector3(-35, 2.5, 25);
            esobject=true;
        }        
        if (!tocado.indexOf("Bausch")){
            objetivo = new BABYLON.Vector3(35.6, 2.5, 26);
            esobject=true;
        }        
        if (!tocado.indexOf("Alcon")){
            objetivo = new BABYLON.Vector3(6, 2.5, 28);
            esobject=true;
        }        
        if (!tocado.indexOf("MD Financial")){
            objetivo = new BABYLON.Vector3(-12.15, 2.5, 26);
            esobject=true;
        }
        if (!tocado.indexOf("MD Financial")){
            objetivo = new BABYLON.Vector3(-12.15, 2.5, 26);
            esobject=true;
        }
        if (!tocado.indexOf("Sacor")){
            objetivo = new BABYLON.Vector3(35.8, 2.5, 14);
            esobject=true;
        }
        if (!tocado.indexOf("Glaukos")){
            objetivo = new BABYLON.Vector3(25.3, 2.5, 14);
            esobject=true;
        }
        if (!tocado.indexOf("TopCon")){
            objetivo = new BABYLON.Vector3(12.9, 2.5, 13.5);
            esobject=true;
        }
        if (!tocado.indexOf("Roche")){
            objetivo = new BABYLON.Vector3(0.2, 2.5, 12.9);
            esobject=true;
        }
        if (!tocado.indexOf("Innova")){
            objetivo = new BABYLON.Vector3(-24.2, 2.5, 15);
            esobject=true;
        }
        if (!tocado.indexOf("Ivantis")){
            objetivo = new BABYLON.Vector3(25.31, 2.5, 1.75);
            esobject=true;
        }
        if (!tocado.indexOf("BioScript")){
            objetivo = new BABYLON.Vector3(12.91, 2.5, 1.6);
            esobject=true;
        }
        if (!tocado.indexOf("Zeiss")){
            objetivo = new BABYLON.Vector3(0.37, 2.5, 1.7);
            esobject=true;
        }
        if (!tocado.indexOf("Seaford")){
            objetivo = new BABYLON.Vector3(-12.5, 2.5, 1.63);
            esobject=true;
        }
        if (!tocado.indexOf("Oculus")){
            objetivo = new BABYLON.Vector3(-25.37, 2.5, 1.4);
            esobject=true;
        }
        if (!tocado.indexOf("McKesson")){
            objetivo = new BABYLON.Vector3(-35.50, 2.5, 1.4);
            esobject=true;
        }
        if (!tocado.indexOf("Aequuspharma")){
            objetivo = new BABYLON.Vector3(25.239, 2.5, -10.84);
            esobject=true;
        }
        if (!tocado.indexOf("Axis")){
            objetivo = new BABYLON.Vector3(12.927, 2.5, -11.324);
            esobject=true;
        }
        if (!tocado.indexOf("Candorvision")){
            objetivo = new BABYLON.Vector3(0.3, 2.5, -10.8);
            esobject=true;
        }
        if (!tocado.indexOf("Natus")){
            objetivo = new BABYLON.Vector3(-12.6, 2.5, -10.8);
            esobject=true;
        }
        if (!tocado.indexOf("COS")){
            objetivo = new BABYLON.Vector3(0, 2.5, -24.4);
            esobject=true;
        }
        if (esobject==false)
        {
            objetivo = new BABYLON.Vector3(pickResult.pickedPoint._x, pickResult.pickedPoint._y+2, pickResult.pickedPoint._z+1.5)
        }
        

        BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, objetivo, 0, ease);
        BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, radiusx, 0, ease);
        var animo = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'beta', 100, 120, cam.beta, BABYLON.Tools.ToRadians(betax), 0, ease);    
        
        //BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, radiusx, 0, ease);
        
        animo.onAnimationEnd = function (){
            scene.activeCamera.upperBetaLimit = BABYLON.Tools.ToRadians(85);
            scene.activeCamera.lowerBetaLimit = BABYLON.Tools.ToRadians(85);
        }
    }
    else
    {
        cam.upperBetaLimit = BABYLON.Tools.ToRadians(85);
        cam.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
        betax=40;

        BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, new BABYLON.Vector3(3,0,18.5), 0, ease);
        
        
        
        var animo = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'beta', 100, 120, cam.beta, BABYLON.Tools.ToRadians(betax), 0, ease);
        var animo2 = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, 80, 0, ease);

        animo.onAnimationEnd = function (){
            cam.upperBetaLimit = BABYLON.Tools.ToRadians(40);
            cam.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
        }
        animo2.onAnimationEnd = function (){
            cam.lowerRadiusLimit = 12;
            cam.upperRadiusLimit = 80;
            zoomed=false;
        }
   
    }
}   
//});

/** Add map-like controls to an ArcRotate camera.
 * @param {BABYLON.Scene} scene
 * @param {BABYLON.ArcRotateCamera} camera
 */
function addControls(scene, camera) {
    camera.inertia = 0.5;
    camera.lowerRadiusLimit = 5;
    camera.upperRadiusLimit = 80;
    camera.lowerAlphaLimit = 1.5680;
    camera.upperAlphaLimit = 1.5680;
    camera.upperBetaLimit = BABYLON.Tools.ToRadians(40);
    camera.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
    

    //camera.upperBetaLimit = Math.PI / 2 - 0.1;
    camera.angularSensibilityX = camera.angularSensibilityY = 1800;

    const plane =
        BABYLON.Plane.FromPositionAndNormal(BABYLON.Vector3.Zero(), BABYLON.Axis.Y);
    
    const inertialPanning = BABYLON.Vector3.Zero();
    
    /** @type {BABYLON.Vector3} */
    let initialPos;
    const panningFn = () => {
        const pos = getPosition(scene, camera, plane);
        panning(pos, initialPos, camera.inertia, inertialPanning);
    };

    const inertialPanningFn = () => {
        if (inertialPanning.x !== 0 || inertialPanning.y !== 0 || inertialPanning.z !== 0) {
            camera.target.addInPlace(inertialPanning);
            //console.log("inertialPanning: "+inertialPanning)
            inertialPanning.scaleInPlace(camera.inertia);
            zeroIfClose(inertialPanning);
        }
    };

    const wheelPrecisionFn = () => {
        camera.wheelPrecision = 1 / camera.radius * 80;
    };

    const zoomFn = (p,e) => {
        const delta = zoomWheel(p,e,camera);
        //zooming(delta, scene, camera, plane, inertialPanning);
    }

    const prvScreenPos = BABYLON.Vector2.Zero();
    const rotateFn = () => {
        rotating(scene, camera, prvScreenPos);
    };

    const removeObservers = () => {
        scene.onPointerObservable.removeCallback(panningFn);
        scene.onPointerObservable.removeCallback(rotateFn);
    }

    scene.onPointerObservable.add((p, e) => {
        removeObservers();
        if (p.event.button === 0) {
            initialPos = getPosition(scene, camera, plane);
            scene.onPointerObservable.add(panningFn, BABYLON.PointerEventTypes.POINTERMOVE);
        } else {
            prvScreenPos.copyFromFloats(scene.pointerX, scene.pointerY);
            scene.onPointerObservable.add(rotateFn, BABYLON.PointerEventTypes.POINTERMOVE);
        }
    }, BABYLON.PointerEventTypes.POINTERDOWN);

    scene.onPointerObservable.add((p, e) => {
        removeObservers();
    }, BABYLON.PointerEventTypes.POINTERUP);

    scene.onPointerObservable.add(zoomFn, BABYLON.PointerEventTypes.POINTERWHEEL);

    scene.onBeforeRenderObservable.add(inertialPanningFn);
    scene.onBeforeRenderObservable.add(wheelPrecisionFn);

    // stop context menu showing on canvas right click
    scene.getEngine().getRenderingCanvas().addEventListener("contextmenu", (e) => {
        e.preventDefault();
    });
}


/** Get pos on plane.
 * @param {BABYLON.Scene} scene
 * @param {BABYLON.ArcRotateCamera} camera
 * @param {BABYLON.Plane} plane
 */
function getPosition(scene, camera, plane) {
    const ray = scene.createPickingRay(
        scene.pointerX, scene.pointerY, BABYLON.Matrix.Identity(), camera, false);
    const distance = ray.intersectsPlane(plane);

    // not using this ray again, so modifying its vectors here is fine
    return distance !== null ?
        ray.origin.addInPlace(ray.direction.scaleInPlace(distance)) : null;
}

/** Return offsets for inertial panning given initial and current
 * pointer positions.
 * @param {BABYLON.Vector3} newPos
 * @param {BABYLON.Vector3} initialPos
 * @param {number} inertia
 * @param {BABYLON.Vector3} ref
 */
function panning(newPos, initialPos, inertia, ref) {
    const directionToZoomLocation = initialPos.subtract(newPos);
   
    /*Esto le habia agregado yo para frenal el paneo
    if (newPos._x > 20 || newPos._x < -20) {
        return;
    } else if (newPos._z > 20 || newPos._z < -20) {
        return;
    }
    */

    const panningX = directionToZoomLocation.x * (1-inertia);
    const panningZ = directionToZoomLocation.z * (1-inertia);
    ref.copyFromFloats(panningX, 0, panningZ);
    return ref;

};

/** Get the wheel delta divided by the camera wheel precision.
 * @param {BABYLON.PointerInfoPre} p
 * @param {BABYLON.EventState} e
 * @param {BABYLON.ArcRotateCamera} camera
 */
function zoomWheel(p, e, camera) {
    const event = p.event;
    event.preventDefault();
    let delta = 0;
    if (event.deltaY) {
        delta = -event.deltaY;
    } else if (event.wheelDelta) {
        delta = event.wheelDelta;
    } else if (event.detail) {
        delta = -event.detail;
    }
    delta /= camera.wheelPrecision;
    

    var cam = scene.activeCamera;
    var ease = new BABYLON.CubicEase();
    ease.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);

    //console.log("radius: "+cam.radius + " beta: "+ BABYLON.Tools.ToDegrees(cam.beta));
    if (cam.radius>5 && BABYLON.Tools.ToDegrees(cam.beta)>50)
    {
        camera.upperBetaLimit = BABYLON.Tools.ToRadians(85);
        camera.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
        betax=40;

        //BABYLON.Animation.CreateAndStartAnimation('at5', cam, 'target', 80, 120, cam.target, BABYLON.Vector3.Zero(), 0, ease);
        
        
        
        var animo = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'beta', 100, 120, cam.beta, BABYLON.Tools.ToRadians(betax), 0, ease);
        //var animo2 = BABYLON.Animation.CreateAndStartAnimation('at4', cam, 'radius', 100, 120, cam.radius, 90, 0, ease);

        animo.onAnimationEnd = function (){
            camera.upperBetaLimit = BABYLON.Tools.ToRadians(40);
            camera.lowerBetaLimit = BABYLON.Tools.ToRadians(40);
            zoomed=false;
        }
        /*
        animo2.onAnimationEnd = function (){
            camera.lowerRadiusLimit = 12;
            camera.upperRadiusLimit = 90;
            zoomed=false;
        }
        */
    }


    //console.log("zoompos: " + zoompos);


    return delta;    
}


/** Zoom to pointer position. Zoom amount determined by delta.
 * @param {number} delta
 * @param {BABYLON.Scene} scene
 * @param {BABYLON.ArcRotateCamera} camera
 * @param {BABYLON.Plane} plane
 * @param {BABYLON.Vector3} ref
 */
function zooming(delta, scene, camera, plane, ref) {
    if (camera.radius - camera.lowerRadiusLimit < 1 && delta > 0) {
        return;
    } else if (camera.upperRadiusLimit - camera.radius < 1 && delta < 0) {
        return;
    }
    const inertiaComp = 1 - camera.inertia;
    if (camera.radius - (camera.inertialRadiusOffset + delta) / inertiaComp <
          camera.lowerRadiusLimit) {
        delta = (camera.radius - camera.lowerRadiusLimit) * inertiaComp - camera.inertialRadiusOffset;
    } else if (camera.radius - (camera.inertialRadiusOffset + delta) / inertiaComp >
               camera.upperRadiusLimit) {
        delta = (camera.radius - camera.upperRadiusLimit) * inertiaComp - camera.inertialRadiusOffset;
    }

    const zoomDistance = delta / inertiaComp;
    const ratio = zoomDistance / camera.radius;
    const vec = getPosition(scene, camera, plane);
    const directionToZoomLocation = vec.subtract(camera.target);
    const offset = directionToZoomLocation.scale(ratio);
    offset.scaleInPlace(inertiaComp);
    ref.addInPlace(offset);

    camera.inertialRadiusOffset += delta;
}

/** Rotate the camera
 * @param {BABYLON.Scene} scene
 * @param {BABYLON.Vector2} prvScreenPos
 * @param {BABYLON.ArcRotateCamera} camera
 */
function rotating(scene, camera, prvScreenPos) {
    const offsetX = scene.pointerX - prvScreenPos.x;
    const offsetY = scene.pointerY - prvScreenPos.y;
    prvScreenPos.copyFromFloats(scene.pointerX, scene.pointerY);
    changeInertialAlphaBetaFromOffsets(offsetX, offsetY, camera);
}

/** Modifies the camera's inertial alpha and beta offsets.
 * @param {number} offsetX
 * @param {number} offsetY
 * @param {BABYLON.ArcRotateCamera} camera
 */
function changeInertialAlphaBetaFromOffsets(offsetX, offsetY, camera) {
    const alphaOffsetDelta = offsetX / camera.angularSensibilityX;
    const betaOffsetDelta = offsetY / camera.angularSensibilityY;
    camera.inertialAlphaOffset -= alphaOffsetDelta;
    camera.inertialBetaOffset -= betaOffsetDelta;
}

/** Sets x y or z of passed in vector to zero if less than Epsilon.
 * @param {BABYLON.Vector3} vec
 */
function zeroIfClose(vec) {
    if (Math.abs(vec.x) < BABYLON.Epsilon) {
        vec.x = 0;
    }
    if (Math.abs(vec.y) < BABYLON.Epsilon) {
        vec.y = 0;
    }
    if (Math.abs(vec.z) < BABYLON.Epsilon) {
        vec.z = 0;
    }
}

var renderFunction=function()
{
    //divFps.innerHTML=engine.getFps().toFixed()+" fps";
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



function cerrarventana()
{
    $('.wmBox_overlay').click();
}

function abrirventana()
{
    if(is_touch_device())
    {
        var win = window.open("khronos", '_blank');
        win.focus();
    }
    else
    {
        $('.wmBox_overlay').fadeIn(750);
        var mySrc = "khronos";
        $('.wmBox_overlay .wmBox_scaleWrap').append('<iframe src="'+mySrc+'">');
        
        $('.wmBox_overlay iframe').click(function(){
            //stopPropagation();
        });
        $('.wmBox_overlay').click(function(){
            //preventDefault();
            $('.wmBox_overlay').fadeOut(750, function(){
                $(this).find('iframe').remove();
            });
        });
    }
}


function abripopup(mensajex){
    mensax=document.getElementById("mensajex");    
    mensax.innerHTML="Tocaste: "+mensajex;    
    //document.getElementById("hover_bkgr_fricc").style.visibility = "visible";
    //document.getElementById("hover_bkgr_fricc").style.display = "block";
    $("#hover_bkgr_fricc").show();
    
};



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
/*
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
*/
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
    //camera.checkCollisions=scene.activeCamera.checkCollisions;
    //camera.applyGravity=scene.activeCamera.applyGravity;
    camera.speed=scene.activeCamera.speed;
    camera.postProcesses=scene.activeCamera.postProcesses;

    camera.applyGravity = true;
    camera.checkCollisions = true;
    camera.ellipsoid = new BABYLON.Vector3(.9, .9, 1);    
    scene.gravity = new BABYLON.Vector3(0, -0.1, 0);
    scene.collisionsEnabled = true;
    

    scene.activeCamera.postProcesses=[];
    scene.activeCamera.detachControl(canvas);
    if(scene.activeCamera.dispose)scene.activeCamera.dispose();
    scene.activeCamera=camera;
    scene.activeCamera.attachControl(canvas);

    
    hideCameraPanel()
};
/*
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
*/
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
