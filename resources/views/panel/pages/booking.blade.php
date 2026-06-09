@extends('panel.layout')

@section('content')
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-center {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: calc(100vh - 160px);
            padding: 30px 30px 80px;
            background: #0b0b14;
            color: white;
            width: 100%;
        }

        .top-text {
            background: #1c1c2f;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            width: 100%;
            max-width: 1100px;
        }

        .top-text h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .title-wrapper {
            width: 100%;
            max-width: 1100px;
            text-align: left;
        }

        .title {
            font-size: 35px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .sub-title {
            color: #b8b8c7;
            margin-bottom: 30px;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 35px;
            width: 100%;
            max-width: 1100px;
        }

        .tab {
            background: #1d1d33;
            padding: 12px 25px;
            border-radius: 30px;
            cursor: default;
            transition: 0.3s;
        }

        .tab.active {
            background: #5b21ff;
        }

        .calendar-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            width: 100%;
            max-width: 1100px;
        }

        .calendar-header {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-btn {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            background: transparent;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0;
        }

        .dropdown-btn::after {
            content: '▼';
            font-size: 14px;
            color: #8e8ea5;
            transition: 0.2s;
        }

        .custom-dropdown.open .dropdown-btn::after {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #252538;
            border: 1px solid #3f3f5a;
            border-radius: 8px;
            min-width: 150px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.5);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            margin-top: 5px;
        }

        .custom-dropdown.open .dropdown-menu {
            display: block;
        }

        .dropdown-menu div {
            padding: 10px 15px;
            cursor: pointer;
            transition: 0.2s;
            color: #b8b8c7;
            font-size: 16px;
        }

        .dropdown-menu div:hover {
            background: #5b21ff;
            color: white;
        }

        .dropdown-menu div.selected {
            background: #3b3b54;
            color: white;
            font-weight: bold;
        }

        .days,
        .dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 10px;
        }

        .days div {
            color: #8e8ea5;
            font-size: 14px;
            padding-bottom: 5px;
        }

        .dates div {
            padding: 12px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            min-height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dates div.empty-day {
            cursor: default;
        }
        
        .dates div.empty-day:hover {
            background: transparent;
        }

        .dates div.calendar-day:hover {
            background: #5b21ff;
            color: #fff;
        }

        .active-date {
            border: 2px solid #5b21ff;
            background: #5b21ff !important;
            color: #fff !important;
            box-shadow: 0 0 15px rgba(91, 33, 255, 0.6);
        }

        .bottom-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            max-width: 1100px;
        }

        .week-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .week-buttons button {
            background: transparent;
            border: 1px solid #555;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
        }

        .week-buttons button:hover,
        .week-buttons .selected {
            background: #5b21ff;
            border: none;
        }

        .result-btn {
            background: #5b21ff;
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 15px;
            font-size: 18px;
            cursor: pointer;
        }

        @media(max-width:768px) {
            .calendar-wrapper {
                grid-template-columns: 1fr;
            }
        }

        .dates .calendar-day.available-date {
            background-color: #22c55e !important;   
            color: #ffffff !important;              
            font-weight: bold !important;
            border-radius: 50% !important;
            cursor: pointer;
        }

        .dates .calendar-day.available-date:hover {
            background-color: #16a34a !important;   
        }

        .disabled-date {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .selection-summary {
            color: #cbd5e1;
            margin-top: 20px;
            width: 100%;
            max-width: 1100px;
            text-align: center;
            font-size: 16px;
        }
    </style>

<div class="main-center">

    <div class="title-wrapper">
        <div class="title">Select your dates</div>
        <div class="sub-title">Minimum stay: 1 month</div>
    </div>

    <div class="tabs">
        <div class="tab active">Pick specific dates</div>
    </div>

    <div class="calendar-wrapper">

        <div class="month" id="cal1">
            <div class="calendar-header">
                <div class="custom-dropdown month-dropdown">
                    <button class="dropdown-btn">May</button>
                    <div class="dropdown-menu"></div>
                </div>
                <div class="custom-dropdown year-dropdown">
                    <button class="dropdown-btn">2026</button>
                    <div class="dropdown-menu"></div>
                </div>
            </div>

            <div class="days">
                <div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div><div>SUN</div>
            </div>
            <div class="dates" id="cal1Dates"></div>
        </div>

        <div class="month" id="cal2">
            <div class="calendar-header">
                <div class="custom-dropdown month-dropdown">
                    <button class="dropdown-btn">June</button>
                    <div class="dropdown-menu"></div>
                </div>
                <div class="custom-dropdown year-dropdown">
                    <button class="dropdown-btn">2026</button>
                    <div class="dropdown-menu"></div>
                </div>
            </div>

            <div class="days">
                <div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div><div>SUN</div>
            </div>
            <div class="dates" id="cal2Dates"></div>
        </div>

    </div>

    <div class="selection-summary" id="selectionSummary">Selected date: <strong id="selectedDateText">None</strong> · Filter: <strong id="selectedOptionText">Exact dates</strong></div>

    <div class="bottom-buttons">
        <div class="week-buttons">
            <button type="button" data-option="exact" class="selected">Exact dates</button>
            <button type="button" data-option="1week">± 1 week</button>
            <button type="button" data-option="2weeks">± 2 weeks</button>
            <button type="button" data-option="3weeks">± 3 weeks</button>
        </div>

        <div style="display:flex;align-items:center;gap:20px;">
            <button type="button" class="result-btn">View results</button>
        </div>
    </div>

</div>

<script>
    const monthsArray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const yearsArray = [2025, 2026, 2027, 2028, 2029, 2030];

    let realAvailableDates = [];
    try {
        realAvailableDates = @json($dbAvailableDates ?? []);
        
        if (realAvailableDates && typeof realAvailableDates === 'object' && !Array.isArray(realAvailableDates)) {
            realAvailableDates = Object.values(realAvailableDates);
        }
    } catch (e) {
        console.error("Failed to parse backend array context: ", e);
    }

    realAvailableDates = realAvailableDates.map(d => {
        if (!d) return '';
        let cleanStr = d.toString().trim();
        if (cleanStr.includes(' ')) cleanStr = cleanStr.split(' ')[0];
        if (cleanStr.includes('T')) cleanStr = cleanStr.split('T')[0];
        return cleanStr;
    }).filter(Boolean);

    console.log("PROCESSED LOOKUP ARRAY ENGINE ACTIVE WITH DATES:", realAvailableDates);

    const urlParams = new URLSearchParams(window.location.search);
    const dateParam = urlParams.get('date');
    const optionParam = urlParams.get('option');
    const initDate = dateParam ? new Date(dateParam) : new Date();

    let selectedDate = dateParam || null;
    let selectedOption = ['exact', '1week', '2weeks', '3weeks'].includes(optionParam) ? optionParam : 'exact';

    let state = {
        cal1: { month: initDate.getMonth(), year: initDate.getFullYear(), selectedDay: dateParam ? initDate.getDate() : null },
        cal2: { month: (initDate.getMonth() + 1) % 12, 
                year: initDate.getMonth() === 11 ? initDate.getFullYear() + 1 : initDate.getFullYear(), 
                selectedDay: null }
    };

    const todayDate = new Date();
    todayDate.setHours(0,0,0,0);

    function closeAllDropdowns() {
        document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
    }

    function setupDropdown(wrapperSelector, defaultVal, itemsList, onSelectCallback) {
        const wrapper = document.querySelector(wrapperSelector);
        if(!wrapper) return;
        const btn = wrapper.querySelector('.dropdown-btn');
        const menu = wrapper.querySelector('.dropdown-menu');
        btn.textContent = defaultVal;

        menu.innerHTML = '';

        itemsList.forEach(item => {
            const div = document.createElement('div');
            div.textContent = item;
            if(item.toString() === defaultVal.toString()) div.classList.add('selected');
            div.addEventListener('click', (e) => {
                e.stopPropagation();
                btn.textContent = item;
                menu.querySelectorAll('div').forEach(el => el.classList.remove('selected'));
                div.classList.add('selected');
                wrapper.classList.remove('open');
                onSelectCallback(item);
            });
            menu.appendChild(div);
        });

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = wrapper.classList.contains('open');
            closeAllDropdowns();
            if(!isOpen) wrapper.classList.add('open');
        });
    }

    document.addEventListener('click', closeAllDropdowns);

    function renderCalendarGrid(calId, containerId) {
        const container = document.getElementById(containerId);
        if(!container) return;
        container.innerHTML = '';

        const currentMonth = state[calId].month;
        const currentYear = state[calId].year;
        const chosenDay = state[calId].selectedDay;

        const totalDays = new Date(currentYear, currentMonth + 1, 0).getDate();

        let startDayIndex = new Date(currentYear, currentMonth, 1).getDay(); 
        startDayIndex = startDayIndex === 0 ? 6 : startDayIndex - 1; 

        for(let s = 0; s < startDayIndex; s++) {
            let emptyDiv = document.createElement('div');
            emptyDiv.classList.add('empty-day');
            container.appendChild(emptyDiv);
        }

        for(let i = 1; i <= totalDays; i++){
            let dateElement = document.createElement('div');
            dateElement.innerText = i;
            dateElement.classList.add('calendar-day');

            const matchYear = currentYear;
            const matchMonth = String(currentMonth + 1).padStart(2, '0');
            const matchDay = String(i).padStart(2, '0');
            const dateStringKey = `${matchYear}-${matchMonth}-${matchDay}`;

            const iterDate = new Date(currentYear, currentMonth, i);
            
            let comparisonInit = null;
            if (dateParam) {
                const parts = dateParam.split('-');
                if (parts.length === 3) {
                    comparisonInit = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                }
            }

            const isAvailable = realAvailableDates.includes(dateStringKey);
            const isPast = iterDate.getTime() < todayDate.getTime();

            if(state[calId].selectedDay !== null && i === chosenDay) {
                dateElement.classList.add('active-date');
            } else if (comparisonInit && iterDate.getTime() === comparisonInit.getTime()) {
                dateElement.classList.add('active-date');
            } else if (isAvailable) {
                dateElement.classList.add('available-date');
            }

            if (isPast) {
                dateElement.classList.add('disabled-date');
                dateElement.style.cursor = 'not-allowed';
            } else {
                dateElement.addEventListener('click', function(){
                    document.querySelectorAll(`.dates div`).forEach(el => {
                        el.classList.remove('active-date');
                    });
                    
                    state.cal1.selectedDay = null;
                    state.cal2.selectedDay = null;

                    state[calId].selectedDay = i;
                    selectedDate = dateStringKey;
                    dateElement.className = 'calendar-day active-date';
                    updateSelectionSummary();
                });
            }

            container.appendChild(dateElement);
        }
    }

    function updateSelectionSummary() {
        const selectedDateText = document.getElementById('selectedDateText');
        const selectedOptionText = document.getElementById('selectedOptionText');
        selectedDateText.textContent = selectedDate || 'None';

        let label = 'Exact dates';
        if (selectedOption === '1week') label = '± 1 week';
        if (selectedOption === '2weeks') label = '± 2 weeks';
        if (selectedOption === '3weeks') label = '± 3 weeks';
        selectedOptionText.textContent = label;
    }

    function applyOptionButtons() {
        const buttons = document.querySelectorAll('.week-buttons button[data-option]');
        buttons.forEach(button => {
            button.classList.toggle('selected', button.dataset.option === selectedOption);
            button.addEventListener('click', () => {
                selectedOption = button.dataset.option;
                buttons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                updateSelectionSummary();
            });
        });
    }

    function initCalendars() {
        setupDropdown('#cal1 .month-dropdown', monthsArray[state.cal1.month], monthsArray, (selectedMonth) => {
            state.cal1.month = monthsArray.indexOf(selectedMonth);
            renderCalendarGrid('cal1', 'cal1Dates');
        });
        setupDropdown('#cal1 .year-dropdown', state.cal1.year, yearsArray, (selectedYear) => {
            state.cal1.year = parseInt(selectedYear);
            renderCalendarGrid('cal1', 'cal1Dates');
        });

        setupDropdown('#cal2 .month-dropdown', monthsArray[state.cal2.month], monthsArray, (selectedMonth) => {
            state.cal2.month = monthsArray.indexOf(selectedMonth);
            renderCalendarGrid('cal2', 'cal2Dates');
        });
        setupDropdown('#cal2 .year-dropdown', state.cal2.year, yearsArray, (selectedYear) => {
            state.cal2.year = parseInt(selectedYear);
            renderCalendarGrid('cal2', 'cal2Dates');
        });

        applyOptionButtons();
        updateSelectionSummary();

        renderCalendarGrid('cal1', 'cal1Dates');
        renderCalendarGrid('cal2', 'cal2Dates');

        document.querySelector('.result-btn').addEventListener('click', () => {
            if (!selectedDate) {
                alert('Please select an available date from the calendar first.');
                return;
            }

            const queryString = new URLSearchParams({
                date: selectedDate,
                option: selectedOption
            }).toString();

            window.location.href = `{{ route('house-detail') }}?${queryString}`;
        });
    }

    initCalendars();
</script>
@endsection