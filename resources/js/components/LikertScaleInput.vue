<script setup>
defineProps({
    name: String,
    id: String,
});
</script>
<template>
    <div class="flex gap-4">
        <label>
            <input type="radio" name="confidence" value="1" />
            Strongly Disagree
        </label>
        <label>
            <input type="radio" name="confidence" value="2" />
            Disagree
        </label>
        <label>
            <input type="radio" name="confidence" value="3" />
            Neutral
        </label>
        <label>
            <input type="radio" name="confidence" value="4" />
            Agree
        </label>
        <label>
            <input type="radio" name="confidence" value="5" />
            Strongly Agree
        </label>
    </div>
</template>
