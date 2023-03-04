<template>
  <k-inside>
    <template v-if="pages.length">
      <k-view class="k-moviereview-view">
        <k-header>{{ title }}</k-header>
        <div class="flex flex-wrap md:flex-nowrap items-start gap-8">
          <nav class="w-full md:w-1/4 shrink-0 min-w-[240px]">
            <ol class="border divide-y divide-black/[.16] border-black/[.16] rounded-md">
              <template v-for="(page, index) in pages">
                <li class="">
                  <k-link :to="page.url" class="flex gap-x-1.5 px-3 py-2.5 leading-snug hover:bg-black/[.1]" :class="{ 'bg-black/[.05]': page.url == $view.path }">
                    <span class="opacity-30">{{ index + 1 }}.</span>
                    <span class="">{{ page.title }}</span>
                  </k-link>
                </li>
              </template>
            </ol>
          </nav>
          <main v-if="page" class="grow bg-white p-4 md:p-8 rounded-lg prose prose-sm md:prose-base max-w-none">
            <h1 class="border-b text-2xl md:text-3xl xl:text-4xl">{{ page.title }}</h1>
            <article v-html="page.content" />
          </main>
        </div>
      </k-view>
    </template>
    <template v-else>
      <k-error-view>There is no documentation pages</k-error-view>
    </template>
  </k-inside>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    pages: {
      type: Array,
      default: () => []
    },
    page: {
      type: Object,
      default: null
    }
  },
  mounted() {
    console.log(this.$view.path)
  }
}
</script>
