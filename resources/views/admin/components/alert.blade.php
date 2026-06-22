<div class="fixed border top-[20px] left-4 right-4 max-w-2xl px-4 py-2 rounded z-50 text-white whitespace-pre-line max-h-[40vh] overflow-y-auto"
     :class="alert.error ? 'bg-red-400 border-red-500' : 'bg-green-400 border-green-500'"
     x-show="alert.show"
     x-text="alert.message"
></div>
