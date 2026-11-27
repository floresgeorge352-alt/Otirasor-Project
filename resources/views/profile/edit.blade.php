<x-app-layout>
    <x-slot name="header">
        <div class="profile-header">
            <div>
                <span class="profile-eyebrow">OTIRASOR BEACH AND RESORT</span>
                <h1>My Profile</h1>
                <p>Manage your personal information and account security.</p>
            </div>
            <div class="profile-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.5" width="34" height="34">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21a8 8 0 0 1 16 0"/>
                </svg>
            </div>
        </div>
    </x-slot>

    <style>
        .profile-page {
            --profile-navy: #142b45;
            --profile-blue: #1d4566;
            --profile-gold: #c9a45c;
            --profile-muted: #718096;
            background: #f4f7fa;
            min-height: 100vh;
            padding: 42px 20px 70px;
            color: #243449;
        }

        .profile-container {
            max-width: 1050px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
        }

        .profile-eyebrow {
            display: block;
            color: #c9a45c;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 7px;
        }

        .profile-header h1 {
            color: #142b45;
            font-size: 25px;
            font-weight: 800;
            margin: 0;
        }

        .profile-header p {
            color: #718096;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 400;
        }

        .profile-header-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c9a45c;
            background: #142b45;
            border-radius: 18px;
            flex-shrink: 0;
        }

        .profile-hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, #142b45, #245476);
            border-radius: 22px;
            padding: 30px 34px;
            color: white;
            margin-bottom: 28px;
            box-shadow: 0 12px 30px rgba(20,43,69,.13);
        }

        .profile-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            right: -65px;
            top: -105px;
        }

        .profile-hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            background: rgba(255,255,255,.13);
            border: 2px solid rgba(201,164,92,.8);
            color: #f1d59e;
            font-size: 28px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .profile-hero h2 {
            color: white;
            font-size: 21px;
            font-weight: 750;
            margin: 0 0 5px;
        }

        .profile-hero p {
            color: #d6e1eb;
            font-size: 13px;
            margin: 0;
        }

        .profile-section {
            background: white;
            border: 1px solid #e8edf2;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 22px;
            box-shadow: 0 5px 20px rgba(20,43,69,.045);
            transition: box-shadow .2s ease, transform .2s ease;
        }

        .profile-section:hover {
            box-shadow: 0 9px 25px rgba(20,43,69,.075);
        }

        .profile-section > div {
            max-width: none !important;
            width: 100%;
        }

        .profile-section section {
            max-width: none !important;
            width: 100%;
        }

        .profile-section h2 {
            color: #142b45 !important;
            font-size: 18px !important;
            font-weight: 750 !important;
            letter-spacing: -.3px;
        }

        .profile-section p {
            color: #718096;
            font-size: 13px;
            line-height: 1.7;
        }

        .profile-section label {
            color: #34465b;
            font-size: 13px;
            font-weight: 650;
        }

        .profile-section input:not([type="checkbox"]):not([type="radio"]) {
            width: 100%;
            min-height: 44px;
            border: 1px solid #dce4ec;
            border-radius: 10px;
            background: #fbfcfe;
            padding: 10px 13px;
            color: #243449;
            font-size: 14px;
            box-shadow: none;
            transition: .2s ease;
        }

        .profile-section input:focus {
            border-color: #c9a45c !important;
            box-shadow: 0 0 0 3px rgba(201,164,92,.13) !important;
            outline: none;
        }

        .profile-section button {
            border-radius: 9px !important;
            padding: 10px 21px !important;
            font-size: 12px !important;
            font-weight: 750 !important;
            letter-spacing: .5px;
            transition: .2s ease;
        }

        .profile-section button:hover {
            transform: translateY(-1px);
        }

        .profile-section button[type="submit"]:not(.text-red-600):not(.bg-red-600) {
            background: #142b45 !important;
            color: white !important;
        }

        .profile-section form {
            margin-top: 22px;
        }

        .profile-section .text-sm {
            font-size: 13px;
        }

        .profile-section .text-red-600,
        .profile-section .text-red-500 {
            color: #dc2626 !important;
        }

        .profile-danger {
            border-left: 4px solid #dc6464;
        }

        .profile-danger h2 {
            color: #a83232 !important;
        }

        .profile-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            padding-top: 10px;
        }

        @media(max-width: 640px) {
            .profile-page {
                padding: 25px 13px 45px;
            }

            .profile-header h1 {
                font-size: 21px;
            }

            .profile-header-icon {
                width: 48px;
                height: 48px;
            }

            .profile-hero {
                padding: 23px 19px;
                border-radius: 17px;
            }

            .profile-avatar {
                width: 58px;
                height: 58px;
                border-radius: 17px;
                font-size: 23px;
            }

            .profile-hero h2 {
                font-size: 18px;
            }

            .profile-section {
                padding: 21px 17px;
                border-radius: 14px;
            }
        }
    </style>

    <div class="profile-page">
        <div class="profile-container">

            <!-- Welcome Banner -->
            <div class="profile-hero">
                <div class="profile-hero-content">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2>Welcome, {{ auth()->user()->name }}!</h2>
                        <p>Keep your account information updated and secure.</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="profile-section">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Security -->
            <div class="profile-section">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="profile-section profile-danger">
                @include('profile.partials.delete-user-form')
            </div>

            <div class="profile-footer">
                © {{ date('Y') }} Otirasor Beach and Resort. All rights reserved.
            </div>

        </div>
    </div>
</x-app-layout>