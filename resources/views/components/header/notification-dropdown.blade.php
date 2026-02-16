<div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
    <a class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border-[0.5px] border-stroke bg-gray hover:text-primary dark:border-strokedark dark:bg-meta-4 dark:text-white"
        href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
        <span class="absolute -top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-meta-1">
            <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-meta-1 opacity-75"></span>
        </span>

        <svg class="fill-current duration-300 ease-in-out" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M16.1999 14.9343L15.6374 14.0624C15.5249 13.8937 15.4687 13.7249 15.4687 13.528V7.67803C15.4687 6.01865 14.7655 4.47178 13.4718 3.31865C12.4312 2.39053 11.0812 1.85615 9.64678 1.85615H8.35303C6.91865 1.85615 5.56865 2.39053 4.52803 3.31865C3.23428 4.47178 2.53116 6.01865 2.53116 7.67803V13.528C2.53116 13.7249 2.47491 13.8937 2.36241 14.0624L1.79991 14.9343C1.63116 15.2155 1.63116 15.553 1.79991 15.8343C1.96866 16.1155 2.24991 16.2843 2.58741 16.2843H15.4124C15.7499 16.2843 16.0312 16.1155 16.1999 15.8343C16.3687 15.553 16.3687 15.2155 16.1999 14.9343ZM9.00003 18.2811C9.61878 18.2811 10.1532 17.8874 10.3219 17.353H7.67816C7.84691 17.8874 8.38128 18.2811 9.00003 18.2811Z"
                fill="" />
        </svg>
    </a>

    <!-- Dropdown Start -->
    <div x-show="dropdownOpen"
        class="absolute right-0 mt-5 flex h-90 w-75 flex-col rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:right-0 sm:w-80"
        style="display: none;">
        <div class="px-4.5 py-3">
            <h5 class="text-sm font-medium text-bodydark2">Notification</h5>
        </div>

        <ul class="flex h-auto flex-col overflow-y-auto">
            <li>
                <a class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4"
                    href="#">
                    <p class="text-sm">
                        <span class="text-black dark:text-white">Edit your information in a swipe</span>
                        Sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt mollit anim.
                    </p>

                    <p class="text-xs">12 May, 2025</p>
                </a>
            </li>
            <!-- Sample Notification Item
      <li>
        <a class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4"
          href="#">
          <p class="text-sm">
            <span class="text-black dark:text-white">It is a long established fact</span>
            that a reader will be distracted by the readable.
          </p>

          <p class="text-xs">24 Feb, 2025</p>
        </a>
      </li>
        -->
        </ul>
    </div>
</div>