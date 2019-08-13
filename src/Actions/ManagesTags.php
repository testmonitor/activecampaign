<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Tag;

trait ManagesTags
{
    /**
     * Get all tags.
     *
     * @return array
     */
    public function tags()
    {
        return $this->transformCollection(
            $this->get('tags'),
            Tag::class,
            'tags'
        );
    }

    /**
     * Find tag by name.
     *
     * @param string $name
     *
     * @return array
     */
    public function findTag($name)
    {
        $tags = $this->transformCollection(
            $this->get('tags', ['query' => ['search' => $name]]),
            Tag::class,
            'tags'
        );

        return array_shift($tags);
    }

    /**
     * Find tag by id.
     *
     * @param string $id
     *
     * @return array
     */
    public function findTagById($id)
    {
        $tags = $this->transformCollection(
            $this->get('tags', ['query' => ['id' => $id]]),
            Tag::class,
            'tags'
        );

        return array_shift($tags);
    }

    /**
     * Create new tag.
     *
     * @param array $data
     *
     * @return Tag
     */
    public function createTag(array $data = [])
    {
        $tags = $this->transformCollection(
            $this->post('tags', ['json' => ['tag' => $data]]),
            Tag::class
        );

        return array_shift($tags);
    }

    /**
     * Find or create a tag.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function findOrCreateTag($name, $type = 'contact', $description = null)
    {
        $tag = $this->findTag($name);

        if ($tag instanceof Tag) {
            return $tag;
        }

        return $this->createTag(['tag' => $name, 'tagType' => $type, 'description' => $description]);
    }

    /**
     * Updates a tag.
     *
     * @param Tag|int|string $id
     * @param string|null    $tag
     * @param string|null    $tagType
     * @param string|null    $description
     *
     * @return Tag|null
     */
    public function updateTag($id, $tag = null, $tagType = 'contact', $description = null)
    {
        $id = $this->getTagId($id);

        $this->put('tags/'.$id, ['json' => ['tag' => compact('tag', 'tagType', 'description', 'orgid')]]);

        return $this->findTagById($id);
    }

    /**
     * Deletes a tag.
     *
     * @param Tag|int|string $tag
     */
    public function deleteTag($tag)
    {
        $this->delete('tags/'.$this->getTagId($tag));
    }

    /**
     * Determines the tag ID.
     *
     * @param Tag|int|string $tag
     */
    protected function getTagId($tag)
    {
        if ($tag instanceof Tag) {
            return $tag->id;
        } elseif (is_numeric($tag)) {
            return (int) $tag;
        } else {
            $tag = $this->findTag($tag);

            return $tag->id;
        }
    }
}
