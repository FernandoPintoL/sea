<template>
  <!-- Table -->
  <!-- <div class="-m-1.5">
    <div class="p-1.5 min-w-full inline-block align-middle"></div>
  </div> -->
  <div class="py-3 px-4">
    <slot name="header-table" />
  </div>
  <div class="overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
      <thead class="bg-gray-50 dark:bg-neutral-800">
        <slot name="tbl-header" />
      </thead>

      <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
        <slot name="tbl-body" />
      </tbody>
    </table>
  </div>
  <!-- End Table -->
</template>
