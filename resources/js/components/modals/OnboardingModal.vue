<script setup>
import { useForm } from "@inertiajs/vue3";
import { defineProps, defineEmits, ref } from "vue";
import Modal from "./Modal.vue";

const emit = defineEmits(["close"]);

const props = defineProps({
    show: Boolean,
});

const form = useForm({
    password: "",
    password_confirmation: "",
});

const active_step = ref(1);
const cookingSkillsQuestions = [
    "Chop, mix, and stir foods (e.g., chopping vegetables, stirring ingredients in a bowl)",
    "Blend foods using a whisk, blender, or food processor",
    "Steam food without it touching the water",
    "Boil or simmer food in a pan of hot water",
    "Stew food by cooking in liquid for over an hour (e.g., beef stew)",
    "Roast food in the oven (e.g., meat, chicken, or vegetables)",
    "Fry or stir-fry food using oil in a pan or wok",
];

const foodPreparationQuestions = [
    "Bake goods (e.g., cakes, buns, cupcakes, scones, or bread)",
    "Peel and chop vegetables (e.g., potatoes, carrots, onions, broccoli)",
    "Prepare and cook raw meat or poultry",
    "Prepare and cook raw fish",
    "Make sauces and gravy from scratch (no jars or granules)",
    "Use herbs and spices for seasoning and flavoring",
];

const answers = ref({});
const likertValues = [1, 2, 3, 4, 5];
const q_index = ref(0);

function submit() {
    console.log("Answers:", answers.value);
    emit("close");
    // Use fetch/axios/Inertia post here
}
</script>

<template>
    <Modal :show="show">
        <form @submit.prevent="submit" class="mt-4 space-y-4">
            <div v-if="active_step === 1">
                <div class="flex">
                    <p class="mb-2 font-semibold">Cooking Skill Confidence</p>
                    <div class="flex text-sm gap-10 ml-auto">
                        <p>Strongly Disagree</p>
                        <p>Disagree</p>
                        <p>Neutral</p>
                        <p>Agree</p>
                        <p>Strongly Agree</p>
                    </div>
                </div>

                <div
                    v-for="(question, index) in cookingSkillsQuestions"
                    :key="index"
                    class="flex items-center border-b-1 border-b-gray-500 p-2"
                >
                    <p class="mb-2 font-semibold w-1/3">{{ question }}</p>
                    <div class="flex gap-20 ml-auto mr-10">
                        <label
                            v-for="value in likertValues"
                            :key="value"
                            class="text-sm text-center"
                        >
                            <input
                                type="radio"
                                :name="q_index + index"
                                :value="value"
                                v-model="answers[index]"
                                required
                            />
                            <div>{{ value }}</div>
                        </label>
                    </div>
                </div>
                <button
                    type="button"
                    @click="active_step = 2"
                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Next
                </button>
            </div>

            <div v-if="active_step === 2">
                <div class="flex">
                    <p class="mb-2 font-semibold">
                        Food Preparation Confidence
                    </p>
                    <div class="flex text-sm gap-10 ml-auto">
                        <p>Strongly Disagree</p>
                        <p>Disagree</p>
                        <p>Neutral</p>
                        <p>Agree</p>
                        <p>Strongly Agree</p>
                    </div>
                </div>

                <div
                    v-for="(question, index) in foodPreparationQuestions"
                    :key="index"
                    class="flex items-center border-b-1 border-b-gray-500 p-2"
                >
                    <p class="mb-2 font-semibold w-1/3">{{ question }}</p>
                    <div class="flex gap-20 ml-auto mr-10">
                        <label
                            v-for="value in likertValues"
                            :key="value"
                            class="text-sm text-center"
                        >
                            <input
                                type="radio"
                                :name="
                                    'q' +
                                    (cookingSkillsQuestions.length + index)
                                "
                                :value="value"
                                v-model="
                                    answers[
                                        cookingSkillsQuestions.length + index
                                    ]
                                "
                                required
                            />
                            <div>{{ value }}</div>
                        </label>
                    </div>
                </div>
                <button
                    type="submit"
                    class="mt-2 bg-green-500 text-white px-4 py-2 rounded"
                >
                    Submit
                </button>
            </div>
        </form>
    </Modal>
</template>
