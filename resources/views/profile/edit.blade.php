@php
$bgImage = asset('frontend/img/ikan.png');
$logo = asset('frontend/img/blputih1.png');
$user = auth()->user();

$avatar = $user->foto
? asset('storage/' . $user->foto)
: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=2545ff&color=ffffff&size=200';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: white;
            background: #10283d;
            overflow: hidden;
        }

        .page {
            width: 100%;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(rgba(13, 38, 58, 0.72), rgba(13, 38, 58, 0.72)),
            url('{{ $bgImage }}') center/cover no-repeat;
            padding-top: 42px;
        }

        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            border: 2px solid #0d8db7;
            border-radius: 12px;
            color: #2bb9ee;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 24px;
            background: rgba(0, 120, 160, 0.25);
            z-index: 20;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.08);
        }

        .logo {
            width: 100%;
            text-align: center;
            margin-bottom: 55px;
        }

        .logo img {
            width: 420px;
            max-width: 80%;
            filter: brightness(1.35) contrast(1.15);
        }

        .profile-card {
            width: 78%;
            max-width: 980px;
            min-height: 365px;
            margin: 0 auto;
            background: rgba(0, 117, 145, 0.58);
            border-radius: 16px;
            padding: 34px 42px;
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .left-profile {
            width: 210px;
            text-align: center;
        }

        .avatar-box {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            cursor: pointer;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 14px;
            object-fit: cover;
            background: #2545ff;
            display: block;
            transition: 0.3s ease;
        }

        .avatar-box:hover .avatar {
            filter: brightness(0.65);
            transform: scale(1.03);
        }

        .avatar-edit {
            position: absolute;
            right: 6px;
            bottom: 6px;
            background: rgba(0, 0, 0, 0.55);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-save,
        .btn-cancel {
            width: 150px;
            height: 48px;
            border-radius: 6px;
            border: none;
            color: white;
            display: block;
            margin: 12px auto;
            text-align: center;
            line-height: 48px;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-save {
            background: #0b55c8;
        }

        .btn-cancel {
            background: #7b8b91;
        }

        .form-area {
            flex: 1;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .input-group i.icon-left {
            width: 50px;
            font-size: 34px;
            color: white;
        }

        .input-wrapper {
            flex: 1;
        }

        .input-wrapper label {
            display: block;
            font-size: 22px;
            margin-bottom: 2px;
        }

        .input-box {
            position: relative;
        }

        .input-box input {
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 5px;
            background: #173653;
            color: white;
            padding: 0 45px 0 12px;
            font-size: 20px;
            outline: none;
        }

        .input-box input.name-input {
            height: 58px;
            font-size: 42px;
            font-weight: bold;
        }

        .input-box i.edit-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: white;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 8px;
            margin: 0 auto 18px;
            width: 78%;
            max-width: 980px;
            font-size: 14px;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            width: 520px;
            max-width: 90%;
            background: #0f5f7a;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.45);
        }

        .drop-area {
            border: 2px dashed rgba(255, 255, 255, 0.65);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 15px;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.08);
        }

        .drop-area.dragover {
            background: rgba(255, 255, 255, 0.22);
        }

        .crop-area {
            width: 100%;
            max-height: 350px;
            display: none;
            margin-bottom: 15px;
        }

        .crop-area img {
            max-width: 100%;
            max-height: 350px;
            display: block;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .modal-btn {
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            color: white;
            cursor: pointer;
        }

        .modal-btn.primary {
            background: #0b55c8;
        }

        .modal-btn.gray {
            background: #7b8b91;
        }
    </style>
</head>

<body>

    <div class="page">

        <a href="{{ route('profile.show') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="logo">
            <img src="{{ $logo }}" alt="Blue Light Aquarium">
        </div>

        @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <input type="file" name="foto" id="fotoInput" accept="image/*" hidden>

            <div class="profile-card">
                <div class="left-profile">
                    <div class="avatar-box" id="openUpload">
                        <img class="avatar" id="avatarPreview" src="{{ $avatar }}" alt="Profile">

                        <div class="avatar-edit">
                            <i class="fa-solid fa-pen"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-save">
                        Save
                    </button>

                    <a href="{{ route('profile.show') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>

                <div class="form-area">
                    <div class="input-group">
                        <i class="icon-left"></i>
                        <div class="input-wrapper">
                            <div class="input-box">
                                <input
                                    type="text"
                                    name="name"
                                    class="name-input"
                                    value="{{ old('name', $user->name) }}"
                                    required>
                                <i class="fa-solid fa-pen edit-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-phone icon-left"></i>
                        <div class="input-wrapper">
                            <label>Phone:</label>
                            <div class="input-box">
                                <input
                                    type="text"
                                    name="no_telp"
                                    value="{{ old('no_telp', $user->no_telp) }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <i class="fa-solid fa-pen edit-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-envelope icon-left"></i>
                        <div class="input-wrapper">
                            <label>Email:</label>
                            <div class="input-box">
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required>
                                <i class="fa-solid fa-pen edit-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <div class="modal" id="cropModal">
        <div class="modal-box">
            <div class="drop-area" id="dropArea">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 34px; margin-bottom: 10px;"></i>
                <p>Klik atau drag & drop foto di sini</p>
                <small>Format JPG/PNG, otomatis crop dan compress</small>
            </div>

            <div class="crop-area" id="cropArea">
                <img id="cropImage">
            </div>

            <div class="modal-actions">
                <button type="button" class="modal-btn gray" id="cancelCrop">Cancel</button>
                <button type="button" class="modal-btn primary" id="saveCrop">Gunakan Foto</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        const openUpload = document.getElementById('openUpload');
        const fotoInput = document.getElementById('fotoInput');
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        const cropArea = document.getElementById('cropArea');
        const dropArea = document.getElementById('dropArea');
        const avatarPreview = document.getElementById('avatarPreview');
        const cancelCrop = document.getElementById('cancelCrop');
        const saveCrop = document.getElementById('saveCrop');

        let cropper = null;

        openUpload.addEventListener('click', () => {
            cropModal.style.display = 'flex';
        });

        dropArea.addEventListener('click', () => {
            fotoInput.click();
        });

        fotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                loadImage(this.files[0]);
            }
        });

        dropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', function() {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            dropArea.classList.remove('dragover');

            const file = e.dataTransfer.files[0];
            if (file) {
                loadImage(file);
            }
        });

        function loadImage(file) {
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                cropImage.src = e.target.result;
                cropArea.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    background: false,
                    responsive: true,
                });
            };

            reader.readAsDataURL(file);
        }

        saveCrop.addEventListener('click', function() {
            if (!cropper) {
                alert('Pilih foto terlebih dahulu.');
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function(blob) {
                const file = new File([blob], 'profile.jpg', {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fotoInput.files = dataTransfer.files;

                avatarPreview.src = URL.createObjectURL(blob);

                cropModal.style.display = 'none';
                cropArea.style.display = 'none';

                cropper.destroy();
                cropper = null;
            }, 'image/jpeg', 0.75);
        });

        cancelCrop.addEventListener('click', function() {
            cropModal.style.display = 'none';
            cropArea.style.display = 'none';
            fotoInput.value = '';

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    </script>

</body>

</html>