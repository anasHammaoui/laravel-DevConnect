@extends('layouts.baseTemplate')

@section('title', 'Edit Profile - DevConnect')

@section('styles')
<style>
    input, textarea, select {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }
    input:disabled {
        background-color: #f3f4f6;
    }
</style>
@endsection

@section('content')
    <div class="container mx-auto px-4">
        <section class="w-full mx-auto">
            <header class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Profile Information
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Update your account's profile information and details.
                </p>
            </header>

            <!-- Profile Overview Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                            <img src="{{ $user->profile_photo_url ?? 'https://placekitten.com/200/200' }}" alt="Profile Image" class="w-32 rounded-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-medium text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            
                            <div class="mt-3">
                                <p class="text-gray-700">{{ $user->bio ?? 'Full-stack developer with 5 years of experience in web technologies.' }}</p>
                            </div>
                            
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach(explode(',', $user->skills ?? 'PHP,Laravel,JavaScript') as $skill)
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <x-input-label for="image" :value="__('Profile Image')" />
                        <div class="flex items-center mt-1">
                            <div class="flex-shrink-0">
                                <img src="{{ $user->profile_photo_url ?? 'https://placekitten.com/200/200' }}" alt="Profile Image" class="h-16 w-16 rounded-full object-cover">
                            </div>
                            <input type="file" id="image" name="image" class="ml-4 text-sm text-gray-600">
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                    </div>

                    <!-- Bio -->
                    <div>
                        <x-input-label for="bio" :value="__('Bio')" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <!-- Social Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="github_url" :value="__('GitHub URL')" />
                            <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full" :value="old('github_url', $user->github_url)" placeholder="https://github.com/username" />
                            <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
                        </div>

                        <div>
                            <x-input-label for="linkedin_url" :value="__('LinkedIn URL')" />
                            <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="mt-1 block w-full" :value="old('linkedin_url', $user->linkedin_url)" placeholder="https://linkedin.com/in/username" />
                            <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
                        </div>
                    </div>

                    <!-- Skills -->
                    <div>
                        <x-input-label for="skills" :value="__('Skills (comma separated)')" />
                        <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->skills)" placeholder="PHP, Laravel, JavaScript, etc." />
                        <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection