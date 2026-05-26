@extends('panel.layout')

@section('content')
    <div class="main-center">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="form-container">
            <img src="https://ucarecdn.com/412d5bde-bec7-49c8-94c9-f6df6434ed12/address.png" alt="Address Form Image"
                class="form-img" />
            <form action="{{ url('/add-house') }}" method="POST" enctype="multipart/form-data">
                <div style="margin-bottom: 2rem">
                    @csrf
                    <h2 class="form-title">Add House</h2>
                    <p class="form-desc">
                        Please provide your address details below. Fields marked
                        with * are required.
                    </p>
                </div>

                <label for="house_name" class="form-label">House Name</label>
                <input type="text" name="house_name" id="house_name" class="form-input" placeholder="Enter your full name"
                    required />
                <label for="email" class="form-label">Email Address(User)</label>
                <input type="email" name="email" id="email" class="form-input" placeholder="Enter your email" required />

                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="form-input" placeholder="Enter your phone number"
                    required />

                <label for="address" class="form-label">Street Address (Line 1)</label>
                <input type="text" name="address" id="address" class="form-input" placeholder="House No., Road Name, etc."
                    required />



                <label for="city" class="form-label">City / Town</label>
                <input type="text" name="city" id="city" class="form-input" placeholder="City or Town" required />


                <label for="division" class="form-label">Division</label>
                <select name="division" id="division" class="form-select" required>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chattogram">Chattogram</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Rajshahi">Rajshahi</option>
                </select>

                <label for="home_price" class="form-label">Rental Price (TK)</label>
                <input type="text" name="home_price" id="home_price" class="form-input"
                    placeholder="Enter your home rental price" required />
                <label for="bed" class="form-label">Number of Bed</label>
                <input type="text" name="bed" id="bed" class="form-input" placeholder="Enter your home's bed number"
                    required />
                <label for="bath" class="form-label">Number of Bath</label>
                <input type="text" name="bath" id="bath" class="form-input" placeholder="Enter your home rental price"
                    required />
                <label for="about" class="form-label">About House</label>
                <input type="text" name="about" id="about" class="form-input" placeholder="Enter your home rental price"
                    required />

                <label for="booking_date" class="form-label">Select Date</label>
                <input type="date" name="booking_date" id="booking_date" class="form-input" min="{{ date('Y-m-d') }}" required>

                <label for="home_image" class="form-label">Upload your home image</label>
                <input type="file" name="home_image" id="home_image" class="form-input" required />


                <button class=" form-btn">Submit Address</button>
            </form>
        </div>
    </div>

    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .main-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            box-sizing: border-box;
        }

        .form-container {
            margin: 0 auto;
            max-width: 570px;
            width: 100%;
            background: white;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .form-img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 200px;
            height: auto;
        }

        .form-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .form-desc {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            text-align: center;
            line-height: 1.5;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: #ffffff;
            font-weight: 500;
            font-size: 1rem;
            color: #111827;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
            margin-bottom: 1.25rem;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #6a64f1;
            box-shadow: 0 0 0 3px rgba(106, 100, 241, 0.2);
        }

        .form-file {
            display: block;
            width: 100%;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            color: #374151;
        }

        .form-file::file-selector-button {
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: #f9fafb;
            color: #374151;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .form-file::file-selector-button:hover {
            background-color: #f3f4f6;
        }

        .form-checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-checkbox {
            margin-top: 0.125rem;
            height: 1.25rem;
            width: 1.25rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            cursor: pointer;
            flex-shrink: 0;
        }

        .form-checkbox:checked {
            background-color: #6a64f1;
            border-color: #6a64f1;
        }

        .form-btn {
            text-align: center;
            width: 100%;
            font-size: 1rem;
            border-radius: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            font-weight: 600;
            background-color: #6a64f1;
            color: white;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background-color 0.2s, box-shadow 0.2s;
        }

        .form-btn:hover {
            background-color: #5a54d1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 600px) {
            .main-center {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection