<!DOCTYPE html>
<html>
<head>
    <title>Draw Signature</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            margin:0; padding:0; height:100%; font-family:sans-serif;
            background: #f9f9f9;
        }

        #sigCanvas {
            width: 100%;
            height: 60vh; /* large enough for signing */
            background-color: #fff9c4; /* light yellow */
            border: 2px solid #333;
            touch-action: none;
            display: block;
        }

        #placeholderText {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: #aaa;
            pointer-events: none;
            text-align: center;
        }

        @media (max-width: 768px) {
            #sigCanvas {
                height: 50vh;
            }
            #placeholderText {
                font-size: 2.5rem;
            }
            .btn-group .btn {
                font-size: 1.5rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-3">

    <!-- Row 1: Signature Canvas -->
    <div class="row mb-3 position-relative">
        <div class="col-12">
            <canvas id="sigCanvas"></canvas>
            <div id="placeholderText">Sign Here</div>
        </div>
    </div>

    <!-- Row 2: Buttons -->
    <div class="row">
        <div class="col-12 d-flex justify-content-center gap-3 btn-group">
            <button class="btn btn-danger" onclick="clearCanvas()">Clear</button>
            <button class="btn btn-success" onclick="saveSignature()">Save</button>
            <button class="btn btn-primary" onclick="closeCanvas()">Close</button>
        </div>
    </div>

</div>

<form id="sigForm" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="signature" id="signatureInput">
</form>

<script>
const canvas = document.getElementById('sigCanvas');
const ctx = canvas.getContext('2d');
let drawing = false;

// Set canvas resolution for devices
function resizeCanvas() {
    const ratio = window.devicePixelRatio || 1;
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    ctx.scale(ratio, ratio);
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

// Get pointer position
function getPointerPos(e){
    const rect = canvas.getBoundingClientRect();
    if(e.touches){
        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
    } else {
        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
    }
}

// Drawing
canvas.addEventListener('mousedown', () => drawing=true);
canvas.addEventListener('mouseup', () => drawing=false);
canvas.addEventListener('mouseout', () => drawing=false);
canvas.addEventListener('mousemove', draw);

canvas.addEventListener('touchstart', (e) => { drawing=true; draw(e); e.preventDefault(); });
canvas.addEventListener('touchend', () => drawing=false);
canvas.addEventListener('touchmove', draw);

function draw(e){
    if(!drawing) return;
    const pos = getPointerPos(e);
    ctx.lineWidth = 2;
    ctx.lineCap = "round";
    ctx.strokeStyle = "#000";
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);

    document.getElementById('placeholderText').style.display = 'none';
}

// Buttons
function clearCanvas(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    document.getElementById('placeholderText').style.display = 'block';
}

function saveSignature(){
    const dataURL = canvas.toDataURL("image/png");
    document.getElementById('signatureInput').value = dataURL;
    document.getElementById('sigForm').submit();
}

function closeCanvas(){
    window.location.href = "/";
}
</script>

</body>
</html>
