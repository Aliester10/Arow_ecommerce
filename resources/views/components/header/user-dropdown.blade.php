<div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
    <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
        <span class="hidden text-right lg:block">
            <span class="block text-sm font-medium text-black dark:text-white">Admin User</span>
            <span class="block text-xs font-medium">Administrator</span>
        </span>

        <span class="h-12 w-12 rounded-full">
            <img src="{{ asset('images/user/user-01.png') }}" alt="User" class="rounded-full"
                onerror="this.src='https://ui-avatars.com/api/?name=Admin+User&background=random'" />
        </span>

        <svg :class="dropdownOpen && 'rotate-180'" class="hidden fill-current sm:block" width="12" height="8"
            viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"
                fill="" />
        </svg>
    </a>

    <!-- Dropdown Start -->
    <div x-show="dropdownOpen"
        class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark z-999999"
        style="display: none;">
        <ul class="flex flex-col gap-5 border-b border-stroke px-6 py-7.5 dark:border-strokedark">
            <li>
                <a href="#"
                    class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base">
                    <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.0001 0.000244141C4.92497 0.000244141 0.00012207 4.92509 0.00012207 11.0002C0.00012207 17.0754 4.92497 22.0002 11.0001 22.0002C17.0753 22.0002 22.0001 17.0754 22.0001 11.0002C22.0001 4.92509 17.0753 0.000244141 11.0001 0.000244141ZM11.0001 4.12524C12.8953 4.12524 14.4376 5.66755 14.4376 7.56274C14.4376 9.45794 12.8953 11.0002 11.0001 11.0002C9.10493 11.0002 7.56262 9.45794 7.56262 7.56274C7.56262 5.66755 9.10493 4.12524 11.0001 4.12524ZM14.9314 17.7565C14.8626 17.8252 14.7801 17.8802 14.6896 17.9177C13.5619 18.3847 12.3197 18.6416 11.0001 18.6416C9.68052 18.6416 8.43828 18.3847 7.31062 17.9177C7.22012 17.8802 7.13762 17.8252 7.06887 17.7565C6.46387 17.1515 5.92212 16.4807 5.46287 15.7533C5.39412 15.6446 5.37887 15.5126 5.41937 15.3908C6.01424 13.626 7.6835 12.3752 9.62512 12.3752H12.3751C14.3167 12.3752 15.986 13.626 16.5809 15.3908C16.6214 15.5126 16.6061 15.6446 16.5374 15.7533C16.0781 16.4807 15.5364 17.1515 14.9314 17.7565Z"
                            fill="" />
                    </svg>
                    My Profile
                </a>
            </li>
        </ul>
        <div class="px-6 py-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base">
                    <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6534 10.3125H11.2501C10.8359 10.3125 10.5001 10.6483 10.5001 11.0625C10.5001 11.4767 10.8359 11.8125 11.2501 11.8125H17.6534L15.3566 14.1093C15.0638 14.4022 15.0638 14.877 15.3566 15.1699C15.5031 15.3163 15.6951 15.3896 15.887 15.3896C16.079 15.3896 16.271 15.3163 16.4174 15.1699L19.9972 11.5901C20.2901 11.2972 20.2901 10.8224 19.9972 10.5295L16.4174 6.94971C16.1246 6.65682 15.6497 6.65682 15.3566 6.94971C15.0638 7.24261 15.0638 7.71749 15.3566 8.01038L17.6534 10.3125ZM9.16675 2.75024C9.16675 2.33603 8.831 2.00024 8.41675 2.00024H5.00008C3.34563 2.00024 2.00008 3.34579 2.00008 5.00024V17.0002C2.00008 18.6547 3.34563 20.0002 5.00008 20.0002H8.41675C8.831 20.0002 9.16675 19.6645 9.16675 19.2502C9.16675 18.836 8.831 18.5002 8.41675 18.5002H5.00008C4.17282 18.5002 3.50008 17.8275 3.50008 17.0002V5.00024C3.50008 4.173 4.17282 3.50024 5.00008 3.50024H8.41675C8.831 3.50024 9.16675 3.16446 9.16675 2.75024Z"
                            fill="" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
    <!-- Dropdown End -->
</div>