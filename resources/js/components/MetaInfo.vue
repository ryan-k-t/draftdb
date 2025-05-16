<template>
    <div class="meta-info">
        <div class="label">{{ label }}</div>
        <div class="value">{{ value }}</div>
    </div>
</template>
<script>
export default {
    props: {
        label: {
            required: true
        },
        value: {
            required: true
        }
    }
}
</script>
