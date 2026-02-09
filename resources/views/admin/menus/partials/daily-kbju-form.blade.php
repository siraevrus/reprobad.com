<div>
    <h3 class="text-lg font-semibold mb-4">Дневное КБЖУ</h3>
    <p class="text-sm text-gray-600 mb-4">Значения рассчитываются автоматически на основе сумм КБЖУ каждого приема пищи</p>
    
    <div class="grid grid-cols-2 gap-6">
        <!-- С перекусом -->
        <div class="border rounded p-4">
            <h4 class="font-semibold mb-4">С перекусом</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Белки</label>
                    <input type="text" x-model="menuData.daily_kbju.with_snack.proteins" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Жиры</label>
                    <input type="text" x-model="menuData.daily_kbju.with_snack.fats" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Углеводы</label>
                    <input type="text" x-model="menuData.daily_kbju.with_snack.carbs" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Калории</label>
                    <input type="text" x-model="menuData.daily_kbju.with_snack.calories" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
            </div>
        </div>

        <!-- Без перекуса -->
        <div class="border rounded p-4">
            <h4 class="font-semibold mb-4">Без перекуса</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Белки</label>
                    <input type="text" x-model="menuData.daily_kbju.without_snack.proteins" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Жиры</label>
                    <input type="text" x-model="menuData.daily_kbju.without_snack.fats" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Углеводы</label>
                    <input type="text" x-model="menuData.daily_kbju.without_snack.carbs" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
                <div>
                    <label class="block text-sm mb-1">Калории</label>
                    <input type="text" x-model="menuData.daily_kbju.without_snack.calories" class="w-full p-2 border rounded bg-gray-50" placeholder="0" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
