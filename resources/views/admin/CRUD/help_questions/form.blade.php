<input-text
        name="question_en"
        label="Question EN"
        placeholder="What is your question ?"
        validation="required"
        default-value="{{isset($entity)?$entity->question_en:(old('question_en'))}}"
></input-text>

<input-text
        name="question_fr"
        label="Question FR"
        placeholder="Quelle est votre question?"
        validation="required"
        default-value="{{isset($entity)?$entity->question_fr:(old('question_fr'))}}"
></input-text>

<input-textarea
        name="answer_en"
        label="Answer EN"
        placeholder="The key is the answer."
        validation="required"
        default-value="{{isset($entity)?$entity->answer_en:(old('answer_en'))}}"

></input-textarea>


<input-textarea
        name="answer_fr"
        label="Réponse FR"
        placeholder="Wingardium leviosa."
        validation="required"
        default-value="{{isset($entity)?$entity->answer_fr:(old('answer_fr'))}}"

></input-textarea>


<p>For the tags below, please add one word per line.</p>
<input-textarea-basic
        name="tags_en"
        label="Tags EN"
        placeholder="tag"
        validation="required"
        default-value="{{isset($entity)?$entity->tags_en:(old('tags_en'))}}"

></input-textarea-basic>
<input-textarea-basic
        name="tags_fr"
        label="Tags FR"
        placeholder="tag"
        validation="required"
        default-value="{{isset($entity)?$entity->tags_fr:(old('tags_fr'))}}"

></input-textarea-basic>