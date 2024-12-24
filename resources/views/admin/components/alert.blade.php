<div class="fixed border top-[20px] px-4 py-2 rounded z-50 text-white"
     :class="alert.error ? 'bg-red-400 border-red-500' : 'bg-green-400 border-green-500'"
     x-show="alert.show"
     x-html="alert.message"
></div>
