<?php

namespace spec\Pim\Component\Catalog\Validator\Constraints;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use PhpSpec\ObjectBehavior;
use Pim\Component\Catalog\AttributeTypes;
use Pim\Component\Catalog\Model\AttributeInterface;
use Pim\Component\Catalog\Model\FamilyInterface;
use Pim\Component\Catalog\Model\FamilyVariantInterface;
use Pim\Component\Catalog\Model\ProductInterface;
use Pim\Component\Catalog\Model\VariantAttributeSetInterface;
use Pim\Component\Catalog\Validator\Constraints\FamilyVariant;
use Pim\Component\Catalog\Validator\Constraints\FamilyVariantValidator;
use Prophecy\Argument;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class FamilyVariantValidatorSpec extends ObjectBehavior
{
    function let(TranslatorInterface $translator, EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($translator, $entityManager, [
            AttributeTypes::METRIC,
            AttributeTypes::OPTION_SIMPLE_SELECT,
            AttributeTypes::BOOLEAN,
            AttributeTypes::REFERENCE_DATA_SIMPLE_SELECT
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FamilyVariantValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_validates_family_variant_axes(
        $entityManager,
        FamilyVariantInterface $familyVariant,
        FamilyInterface $family,
        FamilyVariant $constraint,
        ArrayCollection $axes,
        ArrayCollection $attributes,
        ArrayCollection $attributes1,
        ArrayCollection $attributes2,
        VariantAttributeSetInterface $variantAttributeSet1,
        VariantAttributeSetInterface $variantAttributeSet2,
        ArrayCollection $axes1,
        ArrayCollection $axes2,
        AttributeInterface $color,
        AttributeInterface $size,
        \Iterator $axisIterator,
        \Iterator $attributeIterator,
        UnitOfWork $unitOfWork
    ) {
        $entityManager->getUnitOfWork()->willReturn($unitOfWork);
        $unitOfWork->getOriginalEntityData($familyVariant)->shouldBeCalled();

        $color->getCode()->willReturn('color');
        $color->getType()->willReturn(AttributeTypes::OPTION_SIMPLE_SELECT);
        $color->isLocalizable()->willReturn(false);
        $color->isScopable()->willReturn(false);
        $color->isLocaleSpecific()->willReturn(false);
        $color->isUnique()->willReturn(false);
        $size->getCode()->willReturn('size');
        $size->getType()->willReturn(AttributeTypes::OPTION_SIMPLE_SELECT);
        $size->isLocalizable()->willReturn(false);
        $size->isScopable()->willReturn(false);
        $size->isLocaleSpecific()->willReturn(false);
        $size->isUnique()->willReturn(false);

        $axes->getIterator()->willReturn($axisIterator);
        $axisIterator->valid()->willReturn(true, true, false);
        $axisIterator->current()->willReturn($color, $size);
        $axisIterator->rewind()->shouldBeCalled();
        $axisIterator->next()->shouldBeCalled();

        $attributes->getIterator()->willReturn($attributeIterator);
        $attributeIterator->valid()->willReturn(true, true, false);
        $attributeIterator->current()->willReturn($color, $size);
        $attributeIterator->rewind()->shouldBeCalled();
        $attributeIterator->next()->shouldBeCalled();

        $family->getCode()->willReturn('family');
        $family->hasAttribute(Argument::any())->willReturn(true);
        $familyVariant->getFamily()->willReturn($family);
        $familyVariant->getCode()->willReturn('family_variant');
        $familyVariant->getAxes()->willReturn($axes);
        $familyVariant->getNumberOfLevel()->willReturn(2);
        $familyVariant->getVariantAttributeSet(1)->willReturn($variantAttributeSet1);
        $variantAttributeSet1->getAxes()->willReturn($axes1);
        $variantAttributeSet1->getAttributes()->willReturn($attributes1);
        $attributes1->contains(Argument::any())->shouldBeCalled();
        $axes1->contains(Argument::any())->shouldBeCalled();
        $axes1->count()->willReturn(1);
        $familyVariant->getVariantAttributeSet(2)->willReturn($variantAttributeSet2);
        $variantAttributeSet2->getAxes()->willReturn($axes2);
        $variantAttributeSet2->getAttributes()->willReturn($attributes2);
        $attributes2->contains(Argument::any())->shouldBeCalled();
        $axes2->contains(Argument::any())->shouldBeCalled();
        $axes2->count()->willReturn(1);

        $familyVariant->getAttributes()->willReturn($attributes);
        $attributes->map(Argument::any())->willReturn($attributes);
        $attributes->toArray()->willreturn(['color', 'size']);

        $this->validate($familyVariant, $constraint);
    }

    function it_add_violations_when_axes_are_invalid(
        $translator,
        $entityManager,
        FamilyVariantInterface $familyVariant,
        FamilyInterface $family,
        FamilyVariant $constraint,
        ExecutionContextInterface $context,
        ConstraintViolationBuilderInterface $constraintViolationBuilder,
        VariantAttributeSetInterface $variantAttributeSet1,
        ArrayCollection $axes1,
        ArrayCollection $axes,
        AttributeInterface $color,
        AttributeInterface $size,
        AttributeInterface $weatherCondition,
        \Iterator $axisIterator,
        \Iterator $attributeIterator,
        ArrayCollection $attributes,
        UnitOfWork $unitOfWork
    ) {
        $this->initialize($context);

        $entityManager->getUnitOfWork()->willReturn($unitOfWork);
        $unitOfWork->getOriginalEntityData($familyVariant)->shouldBeCalled();

        $color->getCode()->willReturn('color');
        $color->getType()->willReturn(AttributeTypes::OPTION_SIMPLE_SELECT);
        $color->isLocalizable()->willReturn(true);
        $color->isScopable()->willReturn(false);
        $color->isLocaleSpecific()->willReturn(false);
        $color->isUnique()->willReturn(false);
        $size->getCode()->willReturn('size');
        $size->getType()->willReturn(AttributeTypes::OPTION_SIMPLE_SELECT);
        $size->isLocalizable()->willReturn(false);
        $size->isScopable()->willReturn(true);
        $size->isLocaleSpecific()->willReturn(false);
        $size->isUnique()->willReturn(false);
        $weatherCondition->getCode()->willReturn('weather_conditions');
        $weatherCondition->getType()->willReturn(AttributeTypes::BACKEND_TYPE_DATE);
        $weatherCondition->isLocalizable()->willReturn(false);
        $weatherCondition->isScopable()->willReturn(false);
        $weatherCondition->isLocaleSpecific()->willReturn(true);

        $axes->getIterator()->willReturn($axisIterator);
        $axisIterator->valid()->willReturn(true, true, true, false);
        $axisIterator->current()->willReturn($color, $size, $weatherCondition);
        $axisIterator->rewind()->shouldBeCalled();
        $axisIterator->next()->shouldBeCalled();

        $attributes->getIterator()->willReturn($attributeIterator);
        $attributeIterator->valid()->willReturn(true, true, false);
        $attributeIterator->current()->willReturn($color, $size);
        $attributeIterator->rewind()->shouldBeCalled();
        $attributeIterator->next()->shouldBeCalled();

        $family->getCode()->willReturn('family');
        $family->hasAttribute(Argument::any())->willReturn(true);
        $familyVariant->getFamily()->willReturn($family);
        $familyVariant->getCode()->willReturn('family_variant');
        $familyVariant->getAxes()->willReturn($axes);
        $familyVariant->getNumberOfLevel()->willReturn(1);
        $familyVariant->getVariantAttributeSet(1)->willReturn($variantAttributeSet1);
        $variantAttributeSet1->getAxes()->willReturn($axes1);
        $variantAttributeSet1->getAttributes()->willReturn($attributes);
        $attributes->contains(Argument::any())->shouldBeCalled();
        $axes1->contains(Argument::any())->shouldBeCalled();
        $axes1->count()->willReturn(1);

        $familyVariant->getAttributes()->willReturn($attributes);
        $attributes->map(Argument::any())->willReturn($attributes);
        $attributes->toArray()->willreturn(['color', 'size', 'weather_conditions', 'weather_conditions']);

        $translator->trans('pim_catalog.constraint.family_variant_axes_unique')
            ->willReturn('family_variant_axes_unique');
        $translator->trans('pim_catalog.constraint.family_variant_axes_type')
            ->willReturn('family_variant_axes_type');
        $translator->trans('pim_catalog.constraint.family_variant_axes_wrong_type')
            ->willReturn('family_variant_axes_wrong_type');
        $translator->trans('pim_catalog.constraint.family_variant_axes_attribute_type')
            ->willReturn('family_variant_axes_attribute_type');
        $translator->trans('pim_catalog.constraint.family_variant_attributes_unique')
            ->willReturn('family_variant_attributes_unique');

        $context->buildViolation('family_variant_axes_unique')
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $context->buildViolation('family_variant_axes_wrong_type', ['%axis%' => 'color'])
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $context->buildViolation('family_variant_axes_wrong_type', ['%axis%' => 'size'])
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $context->buildViolation('family_variant_axes_wrong_type', ['%axis%' => 'weather_conditions'])
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $context->buildViolation('family_variant_axes_attribute_type', ['%axis%' => 'weather_conditions'])
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $context->buildViolation('family_variant_attributes_unique', ['%attributes%' => 'weather_conditions'])
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->validate($familyVariant, $constraint);
    }

    function it_only_works_with_family_variant_object(FamilyVariant $constraint, ProductInterface $product)
    {
        $this->shouldThrow(UnexpectedTypeException::class)->during('validate', [$product, $constraint]);
    }

    function it_only_works_with_family_variant_axes_constraint(NotBlank $constraint, FamilyVariantInterface $product)
    {
        $this->shouldThrow(UnexpectedTypeException::class)->during('validate', [$product, $constraint]);
    }
}
