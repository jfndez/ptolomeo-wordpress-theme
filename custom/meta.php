<div class="my_meta_control">
     
    <p>Introducir dirección y breve descripción (opcionales).</p>
 
    <label>Dirección</label>
 
    <p>
        <input type="text" name="_my_meta[name]" value="<?php if(!empty($meta['name'])) echo $meta['name']; ?>"/>
        <span>Introducir la dirección</span>
    </p>
 
    <label>Descripción <span>(texto breve descriptivo)</span></label>
 
    <p>
        <textarea name="_my_meta[description]" rows="3"><?php if(!empty($meta['description'])) echo $meta['description']; ?></textarea>
        <span>Introducir la descripción</span>
    </p>

<p>Introducir dirección y breve descripción (opcionales).</p>
 
    <label>Fuente</label>
 
    <p>
        <input type="text" name="_my_meta[fuente]" value="<?php if(!empty($meta['fuente'])) echo $meta['fuente']; ?>"/>
        <span>Introducir la URL de la fuente o un enlace a información complementaria. Por ejemplo, Wikipedia.</span>
    </p>

<p><strong>Si necesitas añadir nuevos campos o hacer propuestas, puedes escribir a <a href="mailto:jose@jose-fernandez.com.es" target="_blank" title="Contactar con José Fernández" >José Fernández</a>, autor del tema.</strong></p>

</div>
