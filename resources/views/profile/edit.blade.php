<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Dev Community</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .font-header {
            font-family: 'Space Grotesk', sans-serif;
        }

        .blob-profile {
            background: linear-gradient(135deg, #A78BFA, #FCD34D, #86EFAC);
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
            position: absolute;
            animation: moveBlobsProfile 8s infinite alternate;
        }

        @keyframes moveBlobsProfile {
            0% {
                transform: translateY(0) translateX(0);
            }
            100% {
                transform: translateY(-10px) translateX(-10px);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="blob-profile top-0 left-1/4 w-64 h-64"></div>
    <div class="blob-profile bottom-1/4 right-1/4 w-72 h-72"></div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-4xl mx-auto space-y-6 relative z-10">
            <h2 class="text-center font-header text-3xl font-bold text-gray-900 mb-8">
                {{ __('Profile Settings') }}
            </h2>

            <div class="bg-white p-8 rounded-xl shadow-lg space-y-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg space-y-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg space-y-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</body>
</html>
